<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="<?= base_url() ?>assets/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/instascan.min.js"></script>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card-header bg-transparent mb-0">
                    <h5 class="text-center">
                        <span class="font-weight-bold text-primary">Scan</span>
                    </h5>
                </div>
                <div class="card-body">
                    <center><video src="" id="preview" width="300" height="300"></video></center>
                    <div class="form-group">
                        <input type="text" class="form-control" id="hasil_scanner">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview'),
        mirror: false
    });
    scanner.addListener('scan', function(content) {
        $('#hasil_scanner').val(content);
    });

    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            // scanner.start(cameras[0]);
            var selectedCam = cameras[0];
            $.each(cameras, (i, c) => {
                if (c.name.indexOf('back') != -1) {
                    selectedCam = c;
                    return false;
                }
            });

            scanner.start(selectedCam);
        } else {
            console.error('No Cameras Found');
        }
    }).catch(function(e) {
        console.error(e);
    })
</script>