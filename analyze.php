<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['url'])) {
        $url = $_POST['url'];
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hasil</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>

<body>
<h1 align="center">Hasil Analisa</h1>
<script type="text/javascript">
    $(document).ready(function () {
        var subscriptionKey = "bb29424b728845b9bee3881b871f65cb";
        var uriBase = "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";

        // Meminta parameter
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };

        // Menampilkan gambar
        var sourceImageUrl = "<?php echo $url ?>";
        document.querySelector("#sourceImage").src = sourceImageUrl;

        // Memanggil REST API
        $.ajax({
            url: uriBase + "?" + $.param(params),

            // Request headers.
            beforeSend: function (xhrObj) {
                xhrObj.setRequestHeader("Content-Type", "application/json");
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", subscriptionKey);
            },
            type: "POST",

            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })
            .done(function (data) {

                // Menampilkan JSON
                $("#responseTextArea").val(JSON.stringify(data, null, 2));
                $("#description").text(data.description.captions[0].text);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {

                // Menampilkan pesan error
                var errorString = (errorThrown === "") ? "Error. " :
                    errorThrown + " (" + jqXHR.status + "): ";
                errorString += (jqXHR.responseText === "") ? "" :
                    jQuery.parseJSON(jqXHR.responseText).message;
                alert(errorString);
            });
    });
</script>
<br>

<div id="wrapper" style="width:1020px; display:table;">
    <div id="jsonOutput" style="width:600px; display:table-cell;">
        <b style="margin-left: 50px">Respon:</b><br><br>
        <textarea id="responseTextArea" class="UIInput"
                  style="width:580px; height:500px; margin-left: 50px;" readonly=""></textarea>
    </div>
    <div id="imageDiv" style="width:580px; display:table-cell;">
        <b style="margin-left: 24px">Gambar:</b><br><br>
        <img id="sourceImage" width="400" style="margin-left: 24px"/><br>
        <h3 id="description" style="margin-left: 24px">...</h3>
    </div>
</div>
</body>
</html>
