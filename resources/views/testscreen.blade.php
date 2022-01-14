<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('customStyle/app.css') }}">
    <style>
        .sidenav {
            height: 100%;
            width: 340px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #24a5f0;
            overflow-x: hidden;
            padding-top: 20px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .main {
            margin-left: 340px;
            /* Same as the width of the sidenav */
            font-size: 28px;
            /* Increased text to enable scrolling */
            padding: 0px 10px;
        }

        .questionBtn {
            padding: 10px;
            width: 150px;
            font-size: 18pt;
            border: 1px #000 solid;
            background-color: #ffffff;
        }

        .footer {
            margin-left: 340px;
        }

    </style>
</head>

<body>

    <div class="sidenav">
        <h4 class="NotoSanFont text-center">ກົດເພື່ອຂ້າມໄປຂໍ້ທີ່ຕ້ອງການຕອບ {{ session('ticket') }}</h4>
        @php
            $i = 0;
        @endphp

        @foreach ($questions as $question)
            <button id="{{ $question->id }}" class="btn NotoSanFont mb-2 questionBtn" {{($question->answer_selected)? "style=background-color:green":''}}
                onclick="onQuestionClick({{ $question->id }})">{{ $i + 1 }}</button>
            @php
                $i++;       
            @endphp
        @endforeach
        <div class="text-center mt-2">
            <img src="{{ asset('image/logo.png') }}" alt="" srcset="" width="auto" height="150" class="rounded-circle">
        </div>
    </div>

    <div class="main mt-2">
        <div class="container-fluid">
            <div class="row" style="padding-bottom: 1000px;">
                <div class="col-md-10">
                    <h3 class="NotoSanFont">ຊື່ຜູ້ສອບເສັງ:{{ $register->testerFullname }},
                        ເລກທີ່ສອບເສັງ:{{ $register->testingNo }}, ປະເພດສອບເສັງ: <b
                            class="text-danger">{{ $testType->name }}</b></h3>
                    <hr>
                    <h3 class="NotoSanFont" id="question">ຄຳຖາມ: <b id="displayQuestion"></b></h3>
                    <hr>
                    {{-- Area for display image if it is exist --}}
                    <div id="imageArea" class="mt-1">

                    </div>
                    {{-- List for answer --}}
                    <ul id="choiceList" class="NotoSanFont">

                    </ul>
                </div>
                <div class="col-md-2 border-left">
                    <div class="fs-3 fw-bold text-danger border p-1 text-center bg-dark" id="counterDisplay">
                        Loading...
                    </div>
                    <p class="mt-3">
                        <a href="{{ route('stopExamp') }}"
                            class="btn btn-danger NotoSanFont btn-lg">ຢຸດການສອບເສັງ</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar footer fixed-bottom navbar-dark bg-dark" style="height: 150px;">
        <div class="container-fluid">
            {{-- Container to show the choice button --}}
            <div id="answers" class=""></div>
        </div>
    </nav>
</body>
<script>
    let i = 1;
    let time = {{ $register->testing_timespan }};
    let REMEBER_SELECT_BUTTON = "";
    let REMEMBER_ANSWER_SELECT = "";

    //Function when question click
    function onQuestionClick(quest_id) {
        btnCurrentClick = document.getElementById(quest_id);
        btnCurrentClick.style.cssText += "background-color: yellow;";
        callQuestion(quest_id);
        //Change color when select button
        if (REMEBER_SELECT_BUTTON != "") {
            document.getElementById(REMEBER_SELECT_BUTTON).style.cssText = "background-color: #ffffff";
        }
        REMEBER_SELECT_BUTTON = quest_id;
        REMEMBER_ANSWER_SELECT = "";


    }

    //Function When answer has been selected
    function onAnswerSelected(quest_id,answer_id) {
        buttonID = 'answer' + answer_id;
        //If the answer button already pass before
        if (REMEMBER_ANSWER_SELECT) {
            //If Same button was clicked
           
            console.log(REMEMBER_ANSWER_SELECT);
            var oldButton = document.getElementById(REMEMBER_ANSWER_SELECT);
            oldButton.style.cssText = "padding-left:40px; padding-right:40px;";
        }

        //Reset Button Color
        var answerContainer = document.getElementById('answers');
        console.log(answerContainer);




        var thisBtn = document.getElementById(buttonID);
        thisBtn.style.cssText = "background-color:green;padding-left:40px; padding-right:40px;";
        REMEMBER_ANSWER_SELECT = buttonID;

        fetch(window.location.origin + '/api/answer_question/' + quest_id + '/' + answer_id,{
            method: 'get',
            headers:{
                'Content-Type': 'application/json'
            }
        })
        .then(res=>res.json())
        .then(data=>{
            console.log(data);
        });
    }

    //Function call API to get question and answer detail
    function callQuestion(quest_id) {
        fetch('/api/getquestion/' + quest_id, {
                method: 'get',
                headers: {
                    'Content-Type': 'application/json'
                },
            }).then(res => res.json())
            .then(data => {
                //Get question data and display to screen
                console.log(data);
                //element to show question
                document.getElementById('displayQuestion').innerHTML = data.question['question_string'];
                //Element to show answer
                var choiceContainer = document.getElementById('choiceList');
                //Clear answer element before add new one
                choiceContainer.innerHTML = "";
                //Get element to show answer choic button
                var answerContainer = document.getElementById('answers');
                answerContainer.innerHTML = "";
                //Loop choice and add to screen
                //Image container
                var imageContainer = document.getElementById('imageArea');
                imageContainer.innerHTML = "";
                //Add image to html
                if (data.question['photo']) {
                    var imageBox = document.createElement('img');
                    var imageURL = data.question['photo'];
                    imageBox.setAttribute('src', window.location.origin + '/' + imageURL);
                    imageBox.setAttribute('height', '300px');
                    imageBox.setAttribute('width', 'Auto');
                    imageContainer.appendChild(imageBox);

                }

                var answers = data.Answers;
                for (let i = 0; i < answers.length; i++) {
                    var li = document.createElement('li');
                    li.innerHTML = answers[i].answer_title + '. ' + answers[i].answer_text;
                    choiceContainer.appendChild(li);
                    //Create button for user click answer
                    var answerBtn = document.createElement('a');
                    answerBtn.innerHTML = answers[i].answer_title;
                    answerBtn.classList.add('NotoSanFont', 'btn', 'btn-danger', 'me-4', 'fs-2');
                    answerBtn.style.cssText = 'padding-left:40px; padding-right:40px;';
                    //Check answer click ?
                    if(answers[i].id == data.question['answer_selected']){
                        answerBtn.style.cssText = "padding-left:40px; padding-right:40px;background-color:green";
                    }
                    answerBtn.setAttribute('id', 'answer' + answers[i].id);
                    //answerBtn.setAttribute('href',window.location.origin+ '/' + 'answer_question/' + quest_id +'/' + answers[i].id);
                    answerBtn.onclick = function() {
                        onAnswerSelected(quest_id,answers[i].id)
                    };
                    answerContainer.appendChild(answerBtn);
                    //answerBtn.style.cssText = "background-color: #fff;";

                }

            });
    }

    //Function to reset unclick
    function resetButtonClick() {

    }
    //Counting timer function for show in the screen
    function countDown() {

        time = time - 1;
        var min = Math.floor(time / 60);
        var sec = time - (min * 60);
        document.getElementById("counterDisplay").innerHTML = min + ":" + (sec.toString().length == 1 ? '0' + sec
            .toString() : sec.toString());

    }
    //Timer running for counting down to show at screen
    setInterval(() => {
        countDown();

    }, 1000);

    //Timer for running every 5 sec to update the remaining time of user to DB
    //Update for when this user come to test again later
    setInterval(() => {
        //updateUserTimer(time);
        console.log('Fect 5 sec ');
        updateUserTimer(time);
    }, 5000);

    //Send data to update remaining time to db
    function updateUserTimer(time) {
        var data = {
            'timer': time
        };
        fetch('/api/update_user_timer', {
                method: 'post',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            }).then()
            .then().catch((error) => {
                console.log('error', error);
            })
    }
</script>

</html>
