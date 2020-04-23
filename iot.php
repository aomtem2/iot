<?php
$manager = new MongoDB\Driver\Manager('mongodb+srv://aomtem:aomtem2@iot-ksj8r.mongodb.net/test?retryWrites=true&w=majority');
$query = new MongoDB\Driver\Query([]);
$cursor = $manager->executeQuery('test.people', $query);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Websever</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>

<body>

    <br /><br />
    <div class="container">
        <h3 align="center">Button</h3>
        <label class="switch">
            <input type="checkbox" id="togBtn" value="false" name="btn">
            <span class="slider round"></span>
            <h5 align="center">valveM1</h5>
        </label>

        <label class="switch">
            <input type="checkbox" id="togBtn2" value="false" name="btn">
            <span class="slider round"></span>
            <h5 align="center">valveM2</h5>
        </label>

        <label class="switch">
            <input type="checkbox" id="togBtn3" value="false" name="btn">
            <span class="slider round"></span>
            <h5 align="center">valveM3</h5>
        </label>

        <label class="switch">
            <input type="checkbox" id="togBtn4" value="false" name="btn">
            <span class="slider round"></span>
            <h5 align="center">valveM4</h5>
        </label>

        <label class="switch">
            <input type="checkbox" id="togBtn5" value="false" name="btn">
            <span class="slider round"></span>
            <h5 align="center">valveM5</h5>
        </label>

        <label class="switch">
            <input type="checkbox" id="togBtn6" value="false" name="btn">
            <span class="slider round"></span>
            <h5 align="center">motor</h5>
        </label>

        <label class="switch">
            <input type="checkbox" id="togBtn7" value="false" name="btn">
            <span class="slider round"></span>
            <h5 align="center">mode</h5>
        </label>

        <h3 align="center">Datatables</h3>
        <br />
        <div class="table-responsive">
            <table id="employee_data" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td style="text-align:center; width:80px;">Topic</td>
                        <td style="text-align:center; width:80px;">Status</td>
                        <td style="text-align:center; width:80px;">Time</td>
                    </tr>
                </thead>
                <?php
                foreach ($cursor as $document) {
                    echo '  
                    <tr>  
                         <td style="text-align: center;">' . $document->Topic . '</td>  
                         <td style="text-align: center;">' . $document->message . '</td>  
                         <td style="text-align: center;">' . $document->time . '</td>  
                    </tr>  
                    ';
                    // echo "$document->Topic" . "<br/>";
                    // echo "$document->message" . "<br/>";
                    // echo "$document->time" . "<br/>";
                    // var_dump($document->time);
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
<script type="text/javascript">
    client = new Paho.MQTT.Client("postman.cloudmqtt.com", 33525, "client_id");
    // mongodbClient.connect(mongodbURI, setupCollection);
    //Example client = new Paho.MQTT.Client("m11.cloudmqtt.com", 32903, "web_" + parseInt(Math.random() * 100, 10));

    // set callback handlers
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;
    var options = {
        useSSL: true,
        userName: "moeygbny",
        password: "pC13q3K3hqYY",
        onSuccess: onConnect,
        onFailure: doFail
    }

    // connect the client
    client.connect(options);

    // called when the client connects
    function onConnect() {
        // Once a connection has been made, make a subscription and send a message.
        console.log("onConnect");
        client.subscribe("valveM1");
        client.subscribe("valveM2");
        client.subscribe("valveM3");
        client.subscribe("valveM4");
        client.subscribe("valveM5");
        client.subscribe("motor");
        client.subscribe("mode");

    }

    function doFail(e) {
        console.log(e);
    }

    function send(topic, value) {
        message = new Paho.MQTT.Message(value);
        message.destinationName = topic;
        client.send(message);
    }

    // called when the client loses its connection
    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }


    // called when a message arrives
    function onMessageArrived(message) {
        console.log("onMessageArrived:" + message.payloadString + message.destinationName);
        // mongodbClient.connect(mongodbURI, setupCollection);


    }

    var table;
    $(document).ready(function() {
        table = $('#employee_data').DataTable({
            "bFilter": false,
            "bInfo": false,
            "bLengthChange": false,
            "bSort": false,
        });
    });

    $("#togBtn").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).val('1');
            send("valveM1", $(this).val());
        } else {
            $(this).val('0');
            send("valveM1", $(this).val());
        }
        // alert($(this).val());
    });

    $("#togBtn2").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).val('1');
            send("valveM2", $(this).val());
        } else {
            $(this).val('0');
            send("valveM2", $(this).val());
        }
        // alert($(this).val());
    });

    $("#togBtn3").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).val('1');
            send("valveM3", $(this).val());
        } else {
            $(this).val('0');
            send("valveM3", $(this).val());
        }
        // alert($(this).val());
    });

    $("#togBtn4").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).val('1');
            send("valveM4", $(this).val());
        } else {
            $(this).val('0');
            send("valveM4", $(this).val());
        }
        // alert($(this).val());
    });

    $("#togBtn5").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).val('1');
            send("valveM5", $(this).val());
        } else {
            $(this).val('0');
            send("valveM5", $(this).val());
        }
        // alert($(this).val());
    });

    $("#togBtn6").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).val('1');
            send("motor", $(this).val());
        } else {
            $(this).val('0');
            send("motor", $(this).val());
        }
        // alert($(this).val());
    });

    $("#togBtn7").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).val('auto');
            send("mode", $(this).val());
        } else {
            $(this).val('manual');
            send("mode", $(this).val());
        }
        // alert($(this).val());
    });

    // function reload_table() {
    //     table.ajax.reload(null, false); //reload datatable ajax 
    // }

    // var x = setInterval(function() {

    //     <?php
    //     $manager = new MongoDB\Driver\Manager('mongodb+srv://aomtem:aomtem2@iot-ksj8r.mongodb.net/test?retryWrites=true&w=majority');
    //     $query = new MongoDB\Driver\Query([]);
    //     $cursor = $manager->executeQuery('test.people', $query);
    //     ?>
    //     reload_table();
    // }, 1000);
</script>