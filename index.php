<!doctype html>
<html>
    <head>
        <title>ISPark Monitoring App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
       


        <link rel="stylesheet" type="text/css" href="select.css"/>
        <script src="select.js"></script>
        <style type="text/css">
            
            html, body { font-size:13px;}
            .card-header { font-weight: bold; font-size:15px;}
            
        </style>
    </head>
    
    <body>
        <div class="container-fluid" >
            <div class="row mt-3 justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-dark text-light">ISPark Monitoring App</div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4 mt-3">
                                    Select District
                                    <select class="form-control selectpicker mt-1" data-live-search="true" data-size="10" id="selDistrict" title="Select District">

                                    </select>
                                </div>
                                <div class="col-md-8 mt-3">
                                    Select Park
                                    <select class="form-control selectpicker mt-1" data-live-search="true" data-size="10" id="selPark" title="Select Park">
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3" id="mapArea" style="display:none">
                <div class="col-12">
                        <iframe id="mapFrame" width="100%" height="600px" id="gmap_canvas" src="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        <div id="info" class="mt-1">
                            
                        </div>
                </div>                    
            </div>
        </div>
    </body>
</html>

<script>
    
    var parks = [];
    
    $(document).ready(function()
    {
        $.get("backend.php", { op : "listDistrict" }, function(d,s)
        {
            for (var i = 0; i < d.length; i++)
            {
                var x = "<option value='"+d[i]+"'>"+d[i]+"</option>";
                $("#selDistrict").append(x);
            }
            $("#selDistrict").selectpicker('render');
            $("#selDistrict").selectpicker('refresh');
        });
    });
    
    $("#selDistrict").change(function()
    {
        $("#mapArea").hide();
        var val = $(this).val();
        console.log("Selected District : "+val);
        
        $("#selPark").html('');
        $.get("backend.php", { op : "listPark", districtName : val }, function(d,s)
        {
            parks = d;
            
            for (var i = 0; i < parks.length; i++)
            {
                var info = d[i].BosKapasite+" / "+d[i].Kapasitesi;
                var x = "<option value='"+i+"' data-subtext='Parking Lot Status : "+info+"'>"+parks[i].ParkAdi+"</option>";
                $("#selPark").append(x);
            }
            
            $("#selPark").selectpicker('render');
            $("#selPark").selectpicker('refresh');
            
        })
    });
    
    $("#selPark").change(function()
    {
        var val = $(this).val();
        var park = parks[val];

        $("#info").html('');
        var h = "<b>Park Name : </b>"+park.ParkAdi+"<br />";
        h += "<b>Capacity : </b> "+park.BosKapasite+" / "+park.Kapasitesi+"<br />";
        h += "<b>Park Type : </b>"+park.ParkTipi+"<br />";
        h += "<b>Free Parking (Minutes) : "+park.UcretsizParklanmaDk+"<br />";
        $("#info").html(h);
        var url = 'https://maps.google.com/maps?q='+park.Latitude+'%2C%20'+park.Longitude+'&t=&z=17&ie=UTF8&iwloc=&output=embed';
        $("#mapFrame").attr('src', url);
        $("#mapArea").fadeIn();
    })
    
</script>