<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Quote</title>
  </head>
  <body>
    <div class="container p-5">
        <div class="row">
            <div class="col-md-12">
                <h6>Get Quote</h6>
            </div>
        </div>
        <form action="{{route('shipping.rate')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">From Zip</label>
                        <input type="text" name="from_zip" class="form-control" placeholder="10001">
                        @if ($errors->has('from_zip'))
                        <span class="text-danger">{{ $errors->first('from_zip') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">To Zip</label>
                        <input type="text" name="to_zip" class="form-control" placeholder="10003">
                        @if ($errors->has('to_zip'))
                        <span class="text-danger">{{ $errors->first('to_zip') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Weight (KG)</label>
                        <input type="text" name="weight" class="form-control" placeholder="10">
                        @if ($errors->has('weight'))
                        <span class="text-danger">{{ $errors->first('weight') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Length (CM)</label>
                        <input type="text" name="length" class="form-control" placeholder="20">
                        @if ($errors->has('length'))
                        <span class="text-danger">{{ $errors->first('length') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Width (CM)</label>
                        <input type="text" name="width" class="form-control" placeholder="20">
                        @if ($errors->has('width'))
                        <span class="text-danger">{{ $errors->first('width') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Height (CM)</label>
                        <input type="text" name="height" class="form-control" placeholder="20">
                        @if ($errors->has('height'))
                        <span class="text-danger">{{ $errors->first('height') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-info">GET QUOTE</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>