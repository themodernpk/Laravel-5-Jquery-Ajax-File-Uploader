<!DOCTYPE HTML>
<html lang="en">
<head>
    <!-- Force latest IE rendering engine or ChromeFrame if installed -->
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta charset="utf-8">
    <title>Jquery Laravel Upload</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="margin-top: 100px;">

            <!--upload form-->
            <label class="btn btn-default btn-file upload_button">
                <span>Add</span>
                <input type="file" name="files[]" multiple class="hide" id="fileupload" >
            </label>
            <!--upload form-->

            <!--progress-->
            <div class="progress file_progress" style="margin-top: 10px; height: 5px;">
                <div class="progress-bar progress-bar-success" role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                     style="width: 0%;">
                </div>
            </div>
            <!--/progress-->

            <!--file uploaded-->
            <ul class="list-group uploaded_files" style="margin-top: 10px;">
            </ul>
            <!--/file uploaded-->


        </div>

    </div>

</div>

<!--file upload-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.iframe-transport/1.0.1/jquery.iframe-transport.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.17.0/js/jquery.fileupload.min.js"></script>


<script>
    $(function () {
        var filList;
        $('#fileupload').fileupload({
            url: "{{\URL::route('file.uploader')}}",
            dataType: 'json',
            add: function (e, data) {
                var filename = data.files[0].name;
                filenameID = filename.replace(/[^a-z0-9\s]/gi, '').replace(/[_.\s]/g, '-');

                if ($.inArray(filename, filList) !== -1) {
                    alert("Filename already exist");
                    return false;
                }

                filList = [filename];

                //on click to upload
                $('.file_progress').show();

                data.context = $('.upload_button').find('span').text('Uploading...');

                var uploadResponse = data.submit()
                    .error(function (uploadResponse, textStatus, errorThrown) {
                        alert("Error: " + textStatus + " | " + errorThrown);
                        return false;
                    });

            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.progress-bar').css('width', progress + '%');
            },
            done: function (e, data)
            {
                e.preventDefault();

                var filename = data.files[0].name;
                var filenameID = filename.replace(/[^a-z0-9\s]/gi, '').replace(/[_.\s]/g, '-');

                var file_list = "";
                var link = '';

                $.each(data.result.files, function (index, file)
                {
                    link = '<a target="_blank" href="'+file.url+'">'+file.name+'</a>';
                    file_list += '<li class="list-group-item"><button class="btn btn-xs pull-right btn-danger remove_file">X</button> '+link+' </li>';
                });

                $(".uploaded_files").append(file_list);

                $('.file_progress').hide();
                $('.progress-bar').css('width', '0%');
                $('.upload_button').find('span').text('Add');
            },
        });

        $('.uploaded_files').on("click", ".remove_file", function () {
            $(this).closest("li").remove();
            return false;
        });
    });
</script>

<!--/file upload-->

</body>
</html>
