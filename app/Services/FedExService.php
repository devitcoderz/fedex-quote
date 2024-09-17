<?php

namespace App\Services;

use GuzzleHttp\Client;

class FedExService
{
    protected $client;
    protected $key;
    protected $password;
    protected $accountNumber;
    protected $meterNumber;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false  // Disable SSL verification,
        ]);
        $this->key = config('fedex.sandbox') ? config('fedex.quote_key_sandbox') : config('fedex.quote_key_live');
        $this->secret = config('fedex.sandbox') ? config('fedex.quote_secret_sandbox') : config('fedex.quote_secret_live');
        $this->accountNumber = config('fedex.quote_account_number');

        $this->baseUrl = config('fedex.sandbox') ? 'https://apis-sandbox.fedex.com' : 'https://apis.fedex.com';
    }

    public function token(){
        $data = [
            'grant_type'=>'client_credentials',
            'client_id'=>$this->key,
            'client_secret'=>$this->secret
        ];



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/oauth/token');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Return the response instead of outputting it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } 
        curl_close($ch);

        $respo = json_decode($response,true);
        if(isset($respo['access_token'])){
            $finalResult = [
                'success'=>true,
                'response'=>$respo,
                'creds'=>$data
            ];
        }else{
            $finalResult = [
                'success'=>false,
                'response'=>$respo,
                'creds'=>$data
            ];
        }
      
        return $finalResult;
    }

    public function getShippingRate($shipmentDetails)
    {
        $token = $this->token();
        if($token['success']){
            $tok = $token['response']['access_token'];
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer '.$tok,
                'X-locale: en_US',
                'Pragma: no-cache',
                'Cache-Control: no-cache, no-store'
            ];

            $payload["accountNumber"] = [
                "value" => $this->accountNumber
            ];
        
            $payload["rateRequestControlParameters"]["returnTransitTimes"] = true;
        
            $payload["requestedShipment"] = [];
        
            $payload["requestedShipment"]["shipper"]["address"] = [
                "postalCode"    => $shipmentDetails['from_zip'],
                "countryCode"   => "US"
            ];
        
            $payload["requestedShipment"]["recipient"]["address"] = [
                "postalCode"    => $shipmentDetails['to_zip'],
                "countryCode"   => "US"
            ];
        
            $payload["requestedShipment"]["pickupType"] = "CONTACT_FEDEX_TO_SCHEDULE";
        
            $payload["requestedShipment"]["requestedPackageLineItems"][0] = [
                "weight" => [
                    "units" => "KG",
                    "value" => $shipmentDetails['weight']
                ],
                'dimensions'=> [
                    "length"=>$shipmentDetails['length'],
                    "width"=>$shipmentDetails['width'],
                    "units"=>"CM",
                    "height"=>$shipmentDetails['height']
                ],
            ];

        
            $payload["requestedShipment"]["rateRequestType"] = ["ACCOUNT"];
            // $payload["requestedShipment"]["shipDateStamp"] = "2023-08-18";      
        
            

           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/rate/v1/rates/quotes');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Added this to decode the response            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            
            $output         =   curl_exec($ch);
            $http_status    =   curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $content_type   =   curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $curlerr        =   curl_error($ch);
            $header_out     =   curl_getinfo($ch);
            
            curl_close($ch);

            

            if($http_status == 200){
                return json_decode($output,true);
            }else{
                // TO DEBUG OUTPUT
                echo "OUTPUT: ".$output."<br><br>";
                echo "HTTP STATUS: ".$http_status."<br><br>";
                echo "CONTENT TYPE: ".$content_type."<br><br>";
                echo "ERROR: ".$curlerr."<br><br>";
                die();
            }
            
        }else{
            dd($token);
            // foreach($token['response']['errors'] as $k=>$v){
            //     echo $v['message']."<br>";
            // }
            die("==invalid token==");
        }
    }

    public function fedexShipping($from,$to,$package,$shipping){
        $from_addr_lines[] = $from['street_1'];
        if(isset($from['street_2']) && !empty($from['street_2'])):
        $from_addr_lines[] = $from['street_2'];
        endif;

        $to_addr_lines[] = $to['street_1'];
        if(isset($to['street_2']) && !empty($to['street_2'])):
        $to_addr_lines[] = $to['street_2'];
        endif;

        $token = $this->token();
        if($token['success']){
            $tok = $token['response']['access_token'];
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer '.$tok,
                'X-locale: en_US',
                'Pragma: no-cache',
                'Cache-Control: no-cache, no-store'
            ];

            $payload = [
                "labelResponseOptions" => "URL_ONLY", // LABEL / URL_ONLY 
                "requestedShipment" => [
                    "shipper" => [
                        "contact" => [
                            "personName" => $from['first_name']." ".$from['last_name'], 
                            "phoneNumber" => $from['phone_number'], 
                            "companyName" => $from['company'] 
                        ], 
                        "address" => [
                            "streetLines" => $from_addr_lines, 
                            "city" => $from['city'], 
                            "stateOrProvinceCode" => $from['state'], 
                            "postalCode" => $from['zipcode'], 
                            "countryCode" => "US" 
                        ] 
                    ], 
                    "recipients" => [
                        [
                            "contact" => [
                               "personName" => $to['first_name']." ".$to['last_name'], 
                                "phoneNumber" => $to['phone_number'], 
                                "companyName" => $to['company'] 
                            ], 
                            "address" => [
                                "streetLines" => $to_addr_lines, 
                                "city" => $to['city'], 
                                "stateOrProvinceCode" => $to['state'], 
                                "postalCode" => $to['zipcode'], 
                                "countryCode" => "US" 
                            ] 
                        ] 
                    ], 
                    "shipDatestamp" => $package['shipment_date'], 
                    "serviceType" => $shipping['service_type'], //'PRIORITY_OVERNIGHT', 
                    "packagingType" => "YOUR_PACKAGING", //FEDEX_ENVELOPE 
                    "pickupType" => "USE_SCHEDULED_PICKUP", 
                    "blockInsightVisibility" => false, 
                    "shippingChargesPayment" => [
                        "paymentType" => "SENDER" 
                    ], 
                    "shipmentSpecialServices" => [
                        "specialServiceTypes" => [
                            "RETURN_SHIPMENT" 
                        ], 
                        "returnShipmentDetail" => [
                            "returnType" => "PRINT_RETURN_LABEL" 
                        ] 
                    ], 
                    "labelSpecification" => [
                        'labelStockType'=>'PAPER_4X6',
                        'imageType'=>'PNG',//PDF PNG,
                     
                    ], 
                    "requestedPackageLineItems" => [
                        [
                            "weight" => [
                                "value" => $package['weight'], 
                                "units" => "LB" 
                            ],
                            "dimensions"=>[
                                'length'=>$package['length'],
                                'width'=>$package['width'],
                                'height'=>$package['height'],
                                'units'=>'IN'
                            ],
                        ],
                         
                    ] 
                 ], 
                "accountNumber" => [
                    "value" => $this->accountNumber 
                ] 
            ]; 
            
           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/ship/v1/shipments');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Added this to decode the response            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            
            $output         =   curl_exec($ch);
            $http_status    =   curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $content_type   =   curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $curlerr        =   curl_error($ch);
            $header_out     =   curl_getinfo($ch);
            
            curl_close($ch);

            $out  = json_decode($output,true);
            if($http_status == 200){
                return [
                    'status_code'=>$http_status,
                    'response'=>$out
                ];

            }else{
                return [
                    'status_code'=>$http_status,
                    'response'=>$out,
                    'header'=>$header_out,
                    'msg'=> 'Error from the api'                     
                ];
            }

           
            // echo "OUTPUT: ".$output."<br><br>";
            // echo "HTTP STATUS: ".$http_status."<br><br>";
            // echo "CONTENT TYPE: ".$content_type."<br><br>";
            // echo "ERROR: ".$curlerr."<br><br>";
            // die();
        }else{
            dd("invalid token");
        }
    }


    public function fedexLocationByPincode($pincode){
        
        $token = $this->token();
        if($token['success']){
            $tok = $token['response']['access_token'];
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer '.$tok,
                'X-locale: en_US',
                'Pragma: no-cache',
                'Cache-Control: no-cache, no-store'
            ];

            $payload = [
                "locationsSummaryRequestControlParameters" => [
                    "distance" => [
                        "units" => "MI", 
                        "value" => 100
                    ] 
                ], 
                "locationSearchCriterion" => "ADDRESS", 
                "location" => [
                    "address" => [
                        // "city" => "Beverly Hills", 
                        // "stateOrProvinceCode" => "CA", 
                        "postalCode" => $pincode, 
                        "countryCode" => "US" 
                    ] 
                ],
                'sort'=>[
                    'criteria'=>'DISTANCE',
                    'order'=>'ASCENDING'
                ],
                'locationTypes'=>[
                    'FEDEX_OFFICE',
                ],
                // 'locationCapabilities'=>[
                //     [
                //         'daysOfWeek'=>[
                //             "MON","TUE","WED","THU","FRI","SAT","SUN"
                //         ]
                //     ]
                // ]
            ]; 
            
           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/location/v1/locations');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Added this to decode the response            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            
            $output         =   curl_exec($ch);
            $http_status    =   curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $content_type   =   curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $curlerr        =   curl_error($ch);
            $header_out     =   curl_getinfo($ch);
            
            curl_close($ch);

            if($http_status == 200){

                $out  = json_decode($output,true);
                return [
                    'status_code'=>$http_status,
                    'response'=>$out
                ];

            }else{
                return [
                    'status_code'=>$http_status,
                    'response'=>$output,
                    'header'=>$header_out,
                    'msg'=> 'Error from the api'                     
                ];
            }

            

            
            // dd($out['output']['locationDetailList']);
            // echo "<pre>"; print_r($out['output']['locationDetailList'][0]); die;

            // echo "OUTPUT: ".$output."<br><br>";
            // echo "HTTP STATUS: ".$http_status."<br><br>";
            // echo "CONTENT TYPE: ".$content_type."<br><br>";
            // echo "ERROR: ".$curlerr."<br><br>";
            // die();
        }else{

            return [
                'status_code'=>201,
                'msg'=>'Invalid APi Token'
            ];
        }
    }

    public function fedexAddressValidation($from,$to){
        $token = $this->token();
        if($token['success']){
            $tok = $token['response']['access_token'];
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer '.$tok,
                'X-locale: en_US',
                'Pragma: no-cache',
                'Cache-Control: no-cache, no-store'
            ];

            $payload = [
              
                "addressesToValidate" => [
                    [
                        "address" => [
                            "streetLines" => $from['streets'], 
                            "city" => $from['city'], 
                            "stateOrProvinceCode" => $from['state'], 
                            "postalCode" => $from['zipcode'], 
                            "countryCode" => "US" 
                        ] 
                    ],
                    [
                        "address" => [
                            "streetLines" => $to['streets'], 
                            "city" => $to['city'], 
                            "stateOrProvinceCode" => $to['state'], 
                            "postalCode" => $to['zipcode'], 
                            "countryCode" => "US" 
                        ] 
                    ] 
                ] 
            ]; 
            
           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/address/v1/addresses/resolve');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Added this to decode the response            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            
            $output         =   curl_exec($ch);
            $http_status    =   curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $content_type   =   curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $curlerr        =   curl_error($ch);
            $header_out     =   curl_getinfo($ch);
            
            curl_close($ch);

            if($http_status == 200){

                $out  = json_decode($output,true);
                return [
                    'status_code'=>$http_status,
                    'response'=>$out
                ];

            }else{

                $out = json_decode($output,true);
                return [
                    'status_code'=>$http_status,
                    'response'=>$out,
                    'header'=>$header_out,
                    'msg'=> 'Error from the api'                     
                ];
            }


            // echo "<pre>"; print_r(json_decode($output)); die;
            // echo "OUTPUT: ".$output."<br><br>";
            // echo "HTTP STATUS: ".$http_status."<br><br>";
            // echo "CONTENT TYPE: ".$content_type."<br><br>";
            // echo "ERROR: ".$curlerr."<br><br>";
            // die();
        }else{

            return [
                'status_code'=>201,
                'msg'=>'Invalid APi Token'
            ];
        }
    }

    public function fedexServiceAvailability(){
        $token = $this->token();
        if($token['success']){
            $tok = $token['response']['access_token'];
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer '.$tok,
                'X-locale: en_US',
                'Pragma: no-cache',
                'Cache-Control: no-cache, no-store'
            ];

            $payload = [
              
                "addressesToValidate" => [
                    [
                        "address" => [
                            "streetLines" => [
                               "NA", 
                            ], 
                            "city" => "NA", 
                            "stateOrProvinceCode" => "NA", 
                            "postalCode" => "90", 
                            "countryCode" => "US" 
                        ] 
                    ] 
                ] 
            ]; 
            
           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/address/v1/addresses/resolve');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Added this to decode the response            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            
            $output         =   curl_exec($ch);
            $http_status    =   curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $content_type   =   curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $curlerr        =   curl_error($ch);
            $header_out     =   curl_getinfo($ch);
            
            curl_close($ch);

            // if($http_status == 200){

            //     $out  = json_decode($output,true);
            //     return [
            //         'status_code'=>$http_status,
            //         'response'=>$out
            //     ];

            // }else{
            //     return [
            //         'status_code'=>$http_status,
            //         'response'=>$output,
            //         'header'=>$header_out,
            //         'msg'=> 'Error from the api'                     
            //     ];
            // }


            echo "<pre>"; print_r(json_decode($output)); die;
            echo "OUTPUT: ".$output."<br><br>";
            echo "HTTP STATUS: ".$http_status."<br><br>";
            echo "CONTENT TYPE: ".$content_type."<br><br>";
            echo "ERROR: ".$curlerr."<br><br>";
            die();
        }else{

            return [
                'status_code'=>201,
                'msg'=>'Invalid APi Token'
            ];
        }
    }

    public function fedexRatesAndTransitTimes($from,$to,$package){
        $token = $this->token();
        if($token['success']){
            $tok = $token['response']['access_token'];
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer '.$tok,
                'X-locale: en_US',
                'Pragma: no-cache',
                'Cache-Control: no-cache, no-store'
            ];

            $payload = [
                'accountNumber' =>[
                    'value' => $this->accountNumber,
                ],
                'rateRequestControlParameters'=>[
                    'returnTransitTimes'=>true
                ],
                'requestedShipment' =>[
                    'shipper' =>[
                        'address' =>[
                            'city'=>$from['city'],
                            'stateOrProvinceCode'=>$from['state'],
                            'postalCode' => $from['zipcode'],
                            'countryCode' => 'US',
                        ],
                    ],
                    'recipient' =>[
                        'address' =>[ 
                            'city'=>$to['city'],
                            'stateOrProvinceCode'=>$to['state'],
                            'postalCode' => $to['zipcode'],
                            'countryCode' => 'US',
                        ],
                    ],
                    'pickupType' => 'DROPOFF_AT_FEDEX_LOCATION',
                    'rateRequestType' =>[
                        'ACCOUNT',
                        'LIST',
                    ],
                    'requestedPackageLineItems' => [
                        [
                            'weight' => [
                                'units' => 'LB',
                                'value' => $package['weight'],
                            ],
                            'dimensions'=>[
                                'length'=>$package['length'],
                                'width'=>$package['width'],
                                'height'=>$package['height'],
                                'units'=>'IN', //CM IN
                            ]
                        ],
                    ],
                ],
            ];
            
           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/rate/v1/rates/quotes');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Added this on local system to avoid SSL error
            curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Added this to decode the response            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            
            $output         =   curl_exec($ch);
            $http_status    =   curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $content_type   =   curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $curlerr        =   curl_error($ch);
            $header_out     =   curl_getinfo($ch);
            
            curl_close($ch);
            $out  = json_decode($output,true);
            if($http_status == 200){
                return [
                    'status_code'=>$http_status,
                    'response'=>$out
                ];

            }else{
                return [
                    'status_code'=>$http_status,
                    'response'=>$out,
                    'header'=>$header_out,
                    'msg'=> 'Error from the api'                     
                ];
            }


            // echo "<pre>"; print_r(json_decode($output)); die;
            // echo "OUTPUT: ".$output."<br><br>";
            // echo "HTTP STATUS: ".$http_status."<br><br>";
            // echo "CONTENT TYPE: ".$content_type."<br><br>";
            // echo "ERROR: ".$curlerr."<br><br>";
            // die();
        }else{

            return [
                'status_code'=>201,
                'msg'=>'Invalid APi Token'
            ];
        }
    }

}
