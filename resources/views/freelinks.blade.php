<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Free links</h2>
  <form action="{{route('free')}}"method="post">
    <div class="form-group">
      <label for="">Storename:</label>
      <input type="text" class="form-control" id="store" placeholder="Enter Storename" name="store" >
    </div>
    @error('store')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
    <div class="form-group">
      <label for="">Link Number:</label>
      <input type="text" class="form-control" id="number" placeholder="Enter a Number" name="number" >
    </div>
    @error('number')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    
@endif
</body>
</html>
