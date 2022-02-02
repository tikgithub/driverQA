<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('customStyle/app.css') }}">
    <link rel="stylesheet" href="{{ asset('customStyle/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-icons/font/bootstrap-icons.css') }}">
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
            align-items: center;
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
            width: 120px;
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

    <div class="sidenav text-center" id="questionButtonContainer">
        <div class="text-center mt-2">
            <img src="{{ asset('image/logo.png') }}" alt="" srcset="" width="auto" height="100" class="rounded-circle">
        </div>
        <h4 class="NotoSanFont text-center mt-2">ກົດເພື່ອຂ້າມໄປຂໍ້ທີ່ຕ້ອງການຕອບ</h4>
        @php
            $i = 0;
        @endphp

        @foreach ($questions as $question)
            <button id="{{ $question->id }}" class="btn NotoSanFont mb-2 questionBtn"
                {{ $question->answer_selected ? 'style=background-color:green' : '' }} orderBtn={{ $loop->index + 1 }}
                onclick="onQuestionClick({{ $question->id }})"
                {{ $question->answer_selected ? "questionAnswerd=$question->id" : '' }}>{{ $i + 1 }}</button>
            @php
                $i++;
            @endphp
        @endforeach

    </div>

    <div class="main mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 ">
                    <div id="mainScreen">
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
                    <div id="loadingScreen" class="text-center NotoSanFont"
                        style="margin: auto;padding-top:200px; width: 18%; display:none;">
                        <div class="loader"></div>
                        ກະລຸນາລໍຖ້າ
                    </div>
                </div>
                <div class="col-md-2 border-left">


                </div>
            </div>
            <hr>
            <div id="answers" class="text-center">

            </div>

            <div class="fixed-bottom main mb-3 " style="display: inline-flex">
                <a href="{{ route('stopExamp') }}" class="btn btn-danger NotoSanFont btn-lg me-2"><i
                        class="bi bi-stop-circle"></i> ພັກການສອບເສັງ</a>
                <a href="{{ route('submitExam') }}" class="btn btn-success NotoSanFont btn-lg me-2"><i
                        class="bi bi-upload"></i> ສົ່ງບົດສອບເສັງ</a>
                <div class="fs-3 fw-bold text-danger border p-1 text-center bg-dark" id="counterDisplay"
                    style="width: 150px;">Loading...</div>
            </div>
        </div>
    </div>


</body>
<script>
    let i = 1;
    let time = {{ $register->testing_timespan }};
    let REMEBER_SELECT_BUTTON = "";
    let REMEMBER_ANSWER_SELECT = "";
    let NUMBER_OF_ANSWER_QUESTION = [];
    let baseApp = window.location.origin + '{{env('BASE_APP')}}'
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

    //After loading page complete
    //Collect the answer have been answer to array list
    window.onload = function() {
        var questionButtonContainer = document.getElementById('questionButtonContainer').getElementsByTagName(
            'button');
        for (i = 0; i < questionButtonContainer.length; i++) {
            let btn = questionButtonContainer[i];
            let answer_id = btn.getAttribute('questionAnswerd');
            if (answer_id != '' && answer_id != null) {
                NUMBER_OF_ANSWER_QUESTION.push(answer_id);
            }

        }
    };

    //Function when question click
    function onQuestionClick(quest_id) {

        btnCurrentClick = document.getElementById(quest_id);

        callQuestion(quest_id);
        //Change color when select button
        if (REMEBER_SELECT_BUTTON != "") {
            document.getElementById(REMEBER_SELECT_BUTTON).style.cssText = "background-color: #ffffff";
        }
        REMEBER_SELECT_BUTTON = quest_id;
        REMEMBER_ANSWER_SELECT = "";

        var questionButtonContainer = document.getElementById('questionButtonContainer').getElementsByTagName(
            'button');

        for (i = 0; i < NUMBER_OF_ANSWER_QUESTION.length; i++) {

            for (j = 0; j < questionButtonContainer.length; j++) {
                var childButton = questionButtonContainer[j];

                let childButtonID = childButton.getAttribute('questionAnswerd');


                if (childButtonID == NUMBER_OF_ANSWER_QUESTION[i]) {

                    childButton.style.cssText = "background-color:green";
                }
            }
        }
        btnCurrentClick.style.cssText += "background-color: yellow;";


    }

    //Function When answer has been selected
    function onAnswerSelected(quest_id, answer_id) {

        buttonID = 'answer' + answer_id;
        //Reset Button Color
        var answerContainer = document.getElementById('answers').getElementsByTagName('a');
        for (i = 0; i < answerContainer.length; i++) {
            var child = answerContainer[i];
            child.style.cssText = "padding-left:40px; padding-right:40px;";
        }


        var thisBtn = document.getElementById(buttonID);
        thisBtn.style.cssText = "background-color:green;padding-left:40px; padding-right:40px;";
        REMEMBER_ANSWER_SELECT = buttonID;

        fetch(baseApp + '/api/answer_question/' + quest_id + '/' + answer_id, {
                method: 'get',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
            });

        if (!NUMBER_OF_ANSWER_QUESTION.includes(quest_id.toString())) {
            NUMBER_OF_ANSWER_QUESTION.push(quest_id);
            document.getElementById(quest_id).setAttribute('questionAnswerd', quest_id);
        }

        //Get current Order of button when click answer
        var getOrderBtn = document.getElementById(quest_id).getAttribute('orderBtn');
        var nextButtonClick = parseInt(getOrderBtn) + 1;
        console.log(nextButtonClick);
        //Get Next button should selected
        //Check how many button there
        var questionButtonContainer = document.getElementById('questionButtonContainer').getElementsByTagName('button');
        //Check is it last button ?
        if (parseInt(getOrderBtn) >= questionButtonContainer.length) {
            return;
        }
        //Get next button
        var nextButton =document.querySelectorAll("[orderBtn='"+ nextButtonClick +"']")[0].click(); //get current btn + 1 and click



    }

    //Function call API to get question and answer detail
    function callQuestion(quest_id) {
        let mainSection = document.getElementById('mainScreen');
        mainSection.style.cssText = "display:none";
        let loadingScreen = document.getElementById('loadingScreen');
        loadingScreen.style.cssText = "margin: auto;padding-top:200px; width: 18%; display:block;";
        let answers = document.getElementById('answers');
        answers.style.cssText = "display:none";

        fetch(baseApp + '/api/getquestion/' + quest_id, {
                method: 'get',
                headers: {
                    'Content-Type': 'application/json'
                },
            }).then(res => res.json())
            .then(data => {
                //Hide main screen

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
                    imageBox.setAttribute('src', baseApp + '/' + imageURL);
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
                    if (answers[i].id == data.question['answer_selected']) {
                        answerBtn.style.cssText = "padding-left:40px; padding-right:40px;background-color:green";
                    }
                    answerBtn.setAttribute('id', 'answer' + answers[i].id);
                    //answerBtn.setAttribute('href',baseApp+ '/' + 'answer_question/' + quest_id +'/' + answers[i].id);
                    answerBtn.onclick = function() {
                        onAnswerSelected(quest_id, answers[i].id)
                    };
                    answerContainer.appendChild(answerBtn);
                    //answerBtn.style.cssText = "background-color: #fff;";

                }

                /// Show main screen
                mainSection.style.cssText = "display:block";
                loadingScreen.style.cssText = "margin: auto;padding-top:200px; width: 18%; display:none;";
                answers.style.cssText = "display:block";

            }).catch((error) => {
                loadingScreen.style.cssText = "margin: auto;padding-top:200px; width: 18%; display:none;";
                /// Show main screen
                mainSection.style.cssText = "display:block";
                answers.style.cssText = "display:block";
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
        if (time == 0) {
            console.log('time up');
            location.href = baseApp + '/exam/testing_result';
        }

    }
    //Timer running for counting down to show at screen
    setInterval(() => {
        countDown();

    }, 1000);

    //Timer for running every 5 sec to update the remaining time of user to DB
    //Update for when this user come to test again later
    setInterval(() => {
        //updateUserTimer(time);
        //  console.log('Fect 5 sec ');
        updateUserTimer(time);
    }, 5000);

    //Send data to update remaining time to db
    function updateUserTimer(time) {
        var data = {
            'timer': time
        };
        fetch(baseApp + '/api/update_user_timer', {
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
