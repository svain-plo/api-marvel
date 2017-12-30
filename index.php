
<html lang="en">
    <head>
        <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
        <link href="slick.css" rel="stylesheet" type="text/css">
        <style>
            body{
                background-size: cover;
                text-align: center;
                color: white;
                font-family: "Permanent Marker";
            }
            .content{
                position: relative;
                z-index: 2;
                width:80%;
                margin-left: 10%;
            }
            ul{
                background: white;
                list-style: none;
                padding: 0;
                left:0 !important;
                text-align: center;
                color: #000;
                z-index:5;
            }
            div[role='status']{
                display: none;
            }
            h2{
                color:white;
                text-align: center;
                text-transform: uppercase;
                margin-top: 150px;
                font-size: 3em;
                text-shadow: 0px 0px 05px rgb(0,0,0);
            }
            input{
                width:20%;
                height:20px;
                border: none;
                box-shadow: 0px 0px 05px rgb(255,255,255);
                display: block;
                margin: auto;
            }
            button{
                width:20%;
                margin: auto;
                display: block;
                height:20px;
                border: none;
                background: red;
                color: white;
                margin-top: 10px;
                box-shadow: 0px 0px 05px rgb(255,255,255);
            }
            h1,p{
                text-shadow: 0px 0px 05px rgb(0,0,0);
            }
            .bg{
                position: fixed;
                z-index: 0;
                width:100vw;
                left:0;
                right:0;
                top:0
            }
            .content-bg{
                width:100vw;
            }
            .content-bg img{
                width:100%;
            }
            .slick-arrow{
                position: absolute;
                top:40%;
                left:50px;
                z-index: 88888;
                width:auto;
            }
            .slick-arrow:last-child{
                left:auto;
                right:50px;
            }
        </style>
    </head>
    <body>
        <div class="bg">
            <div class="content-bg">
                <img src="http://www.screengeek.net/wp-content/uploads/2017/05/marvel-comics.jpg"/>
            </div>
            <div class="content-bg">
                <img src="http://themeparkuniversity.com/wp-content/uploads/2016/04/IMG-Worlds-of-Adventure-11-1.jpg"/>
            </div>
        </div>
        <div class="content">
            <embed src="music.mp3" autostart="true" loop="false" hidden="true"></embed>
            <h2>Recherche ton super héros</h2>
            <input id="plo" type="text" name="sh"/>
            <button class="submit">Chercher</button>
            <h1 class="nom"></h1>
            <p class="description"></p>
            <div class="img"></div>
        </div>
    </body>
</html>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="./jquery-ui.min.js"></script>
<script src="./slick.min.js"></script>
<script>
    $('.bg').slick();
    var resultat = [];
    $('input').autocomplete({
        source : function (request, response) {
            var data=$('#plo').val();
            console.log('ici', data);
            $.ajax({
                url : 'https://gateway.marvel.com:443/v1/public/characters?nameStartsWith='+data+'&apikey=660a0c7d86bb5bfdbe288060bb5d79c6',
                type : 'GET',
                dataType : 'json',
                success : function(result){
                    var donnees=result.data.results;
                    resultat = [];
                    //console.log("donnees", donnees)
                    $.each(donnees, function(i, item) {
                        resultat.push(donnees[i].name);
                        //console.log(donnees[i].name);
                    })
                    //console.log(resultat);
                    response(resultat);
                }
            });
        },
        select: function(event, ui) {
            submit(ui.item.label);
        },
        minLength: 3
    });

   function submit(event){
        var input_val=event;
        $.ajax({
            url : 'https://gateway.marvel.com:443/v1/public/characters?name='+input_val+'&apikey=660a0c7d86bb5bfdbe288060bb5d79c6',
            type : 'GET',
            dataType : 'json',
            success : function(result){
                var donnees=result.data.results[0];
                $('.nom').text(donnees.name);
                $('.description').text(donnees.description);
                $('.img').html('<img src="'+donnees.thumbnail.path+'.'+donnees.thumbnail.extension+'" width=" 150px;"/>');
            }
        });
    }
</script>