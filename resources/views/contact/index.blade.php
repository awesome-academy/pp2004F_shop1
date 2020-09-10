<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    <h1>Contact</h1>
    <form method="post" action="{{ route('contact_save', $contacts->id) }}">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="ExampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" required="required" value="{{ $contacts->name }}">
                </div>

                <div class="form-group">
                    <label for="ExampleInputEmail1">Email</label>
                    <input type="name" class="form-control" name="email" required="required" value="{{ $contacts->email }}">
                </div>

                <div class="form-group">
                    <label for="ExampleInputEmail1">Subject</label>
                    <input type="name" class="form-control" name="subject" required="required" value="{{ $contacts->subject }}">
                </div>

                <div class="form-group">
                    <label for="ExampleInputEmail1">Message</label>
                    <textarea type="text" class="form-control" name="message" rows="3" required="required">{{ $contacts->message }}</textarea>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
