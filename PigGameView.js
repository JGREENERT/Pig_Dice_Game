"use strict";
var PigGameView = (function() {
    var init = function() {
        var set = false;
        var error = false;
        var control;
        var dice;
        var players;
        var interval;
        var PTW;
        var preferredColor;
        var preferredName;
        var roomNumber = -1;
        var socket;

        var host = "ws://148.61.162.206:9000/";
        socket = new WebSocket(host);
        socket.onopen = function (msg) {
            console.log("Welcome - status " + this.readyState);
            socket.send("my name is:" + document.getElementById("pName").value);
        };
        socket.onmessage = function (msg) {
            console.log("client socket.onMessage = " + msg.data);
            var split = msg.data.split(":");
            var command = split[0];
            var values = split[1];
            switch (command) {
                case "start game":
                    console.log("received start game");
                    startGame();
                    break;

                case "room full":
                    console.log("received room full");
                    //display error saying room is full
                    break;

                case "joined room":
                    console.log("joined room: " + values);
                    var roomInfo = values.split(",");
                    roomNumber = roomInfo[0];
                    document.getElementById("NOP").value = roomInfo[1];
                    document.getElementById("PTW").value = roomInfo[2];
                    document.getElementById("NOD").value = roomInfo[3];
                    createInnerForm();
                    setPlayerNames(roomInfo[4]);
                    break;
                case "room created":
                    console.log("received room created");
                    roomNumber = values;
                    createInnerForm();
                    break;

                case "end turn":
                    console.log("received end turn");
                    endTurnButtonClicked();
                    break;

                case "roll dice":
                    console.log("received roll dice");
                    rollDiceButtonClicked();
                    break;

                case "owner left":
                    console.log("received owner left");
                    resetForm();
                    break;

                default:
                    console.log("received default case");
            }

        };
        socket.onclose = function (msg) {
            console.log("Disconnected - status " + this.readyState);
        };

        function sendMessage(msg)
        {
            console.log("Sending message to server : " + msg);
            socket.send(msg);
        }

        /*
         * Sets a cookie with the specified form
         * settings values.
         */
        function setCookie() {
            document.cookie = "name=" + preferredName + "=color=" + preferredColor;
            console.log("name=" + preferredName + "=color=" + preferredColor);
        }

        /*
         * Validates the form input entered
         * by the player, and starts the game if
         * the input was valid. Is also called to reset
         * the form.
         */
        var validateInput = function (event) {
            event.preventDefault();
            if (!set) {
                var message = document.getElementById("Error").childNodes;

                /*Resetting Error Message*/
                if (error) {
                    document.getElementById("Error").removeChild(message[0]);
                }

                /*Getting Form Values*/
                var NOP = document.getElementById("NOP").value;
                var PTW = document.getElementById("PTW").value;
                var NOD = document.getElementById("NOD").value;

                /*Input is not a Number*/
                if (isNaN(NOP) || isNaN(PTW) || isNaN(NOD)) {
                    console.log("Not a Number");
                    setErrorMessage("Please make sure all fields are a number");
                }
                /*Input is Negative*/
                else if (NOP < 0 || PTW < 0 || NOD < 0) {
                    console.log("Is Negative");
                    setErrorMessage("Please make sure all fields contain a Positive number");
                }

                /*Input is a Decimal*/
                else if (NOP % 1 != 0 || PTW % 1 != 0 || NOD % 1 != 0) {
                    console.log("Is a Decimal");
                    setErrorMessage("Please make sure all fields contain a Whole number");
                }

                else if (NOP == "" || PTW == "" || NOD == "") {
                    console.log("Is empty");
                    setErrorMessage("Please make sure all fields contain a value");
                }
                else {
                    error = false;
                    sendMessage("create room:" + NOP + "," + PTW + "," + NOD + "," + document.getElementById("pName").value);
                }
            } 
            else
                sendMessage("delete room:" + roomNumber);
        };

        /*
         *   Sets the error message for a specified error
         */
        function setErrorMessage(message) {
            var NANPara = document.createElement("p");
            NANPara.setAttribute('style', "text-shadow: 2px 2px 4px #FFFFFF; font-size:x-large; text-align:center; color: red");
            var NANContent = document.createTextNode(message);
            NANPara.appendChild(NANContent);
            document.getElementById("Error").appendChild(NANPara);
            error = true;
        }

        function sendStartGame(event)
        {
            event.preventDefault();
            socket.send("start game:" + roomNumber);
        }

        function sendEndTurn(event)
        {
            event.preventDefault();
            socket.send("end turn:" + roomNumber);
        }

        function sendRollDice(event)
        {
            event.preventDefault();
            socket.send("roll dice:" + roomNumber);
        }

        function sendJoin(roomPressed, event) {
            event.preventDefault();
            console.log("join room:" + roomPressed);
            socket.send("join room:" + roomPressed);
        }

        /*
         *   Creates the form for user to insert player
         *   names and start the game.
         */
        var createInnerForm = function () {
            /*Hiding the Settings Box*/
            document.getElementById("Settings").style.display = 'none';

            /*Getting Preferred Color*/
            preferredColor = document.getElementsByTagName("fieldset")[0].style.borderColor;

            if (document.getElementById("Inner Form").hasChildNodes()) {
                document.getElementById("Inner Form").removeChild(document.getElementById("Inner Form").children[0]);
            }


            /*Setting up Player Name HTML*/
            var playerForm = document.createElement("form");
            var numOfPlayers = document.getElementById("NOP").value;
            for (var i = 0; i < numOfPlayers; i++) {
                var playerItem = document.createElement("input");
                playerItem.setAttribute('type', "text");
                playerItem.setAttribute('name', 'Player' + i + 'Name');
                playerItem.setAttribute('id', 'Player' + i);
                playerItem.setAttribute('value', " ");
                playerItem.setAttribute('readonly', "readonly");
                playerForm.appendChild(playerItem);
            }
            /*Creating Player Name HTML and adding Play Button*/
            playerForm.appendChild(document.createElement("br"));
            var submitButton = document.createElement("button");
            submitButton.style.backgroundColor = preferredColor;
            var codeText = document.createElement("code");
            codeText.style.cssText =  'font-size:small;color:White;text-shadow: 2px 2px 4px #000000;';
            codeText.innerHTML = "Play";
            submitButton.appendChild(codeText);
            playerForm.appendChild(submitButton);
            document.getElementById("Inner Form").appendChild(playerForm);
            document.getElementById("Inner Form").addEventListener("click", sendStartGame);

            /*Setting Preferred Name to Player 0 Spot*/
            if (document.getElementById("pName").value != "") {
                preferredName = document.getElementById("pName").value;
                document.getElementById("Player" + 0).value = preferredName;
            }

            /*Changing set to reset event listener*/
            set = true;
            document.getElementById("submit").children[0].textContent = "Reset";

            /* set input fields to unmodifiable until reset is pressed.*/
            document.getElementById("NOP").setAttribute('readonly', "readonly");
            document.getElementById("PTW").setAttribute('readonly', "readonly");
            document.getElementById("NOD").setAttribute('readonly', "readonly");

        };

        function setPlayerNames(playerNames) {
            var names = playerNames.split(" ");
            console.log(names);
            console.log(document.getElementById("Inner Form").children[0].getElementsByTagName("input"));
            var playerInputs = document.getElementById("Inner Form").children[0].getElementsByTagName("input");
            for (var i = 0; i < playerInputs.length; i++){
                playerInputs[i].value = names[i];
            }
        }

        /*
         *   Resets the form if a user wants to make
         *   a different selection
         */
        var resetForm = function () {

            /* set input fields to modifiable until reset is pressed.*/
            document.getElementById("NOP").removeAttribute('readonly');
            document.getElementById("PTW").removeAttribute('readonly');
            document.getElementById("NOD").removeAttribute('readonly');

            /*Resetting Outer Form Values for Reset*/
            document.getElementById("NOP").value = "";
            document.getElementById("PTW").value = "";
            document.getElementById("NOD").value = "";

            /*Removing the Player Name HTML*/
            var InnerForm = document.getElementById("Inner Form").childNodes;
            document.getElementById("Inner Form").removeChild(InnerForm[0]);

            /*Re-show the Setting Box with same preferred values*/
            document.getElementById("Settings").style.display = 'block';

            /*Changing reset to set event listener*/
            set = false;
            document.getElementById("submit").children[0].textContent = "Set";
        };

        /*
         *   Starts the Game by calling the Pig Game View
         *   and creating the UI by manipulating the DOM
         */
        var startGame = function () {
            setCookie();

            /*Hiding "setUp" HTML*/
            document.getElementById("setUp").style.display = 'none';

            /*Adding Game UI HTML*/
            document.getElementById("Game").style.display = 'block';

            /*Starting Game*/
            PTW = document.getElementById("PTW").value;
            var NOP = document.getElementById("NOP").value;
            var NOD = document.getElementById("NOD").value;

            var playerNames = [];
            for (var i = 0; i < NOP; i++) {
                var child = document.createElement("div");
                var name = document.getElementById("Player" + i).value;
                child.id = name;
                child.innerText = name + "'s score: 0";
                document.getElementById("PlayersDiv").appendChild(child);
                playerNames.push(name)
            }


            control = PigGameControl.init(playerNames, NOD, PTW);
            control.setDiceSeeds(roomNumber);
            dice = control.getAllDice();
            players = control.getAllPlayers();
            console.log(players);

            document.getElementById("RD").addEventListener("click", sendRollDice);
            document.getElementById("END").addEventListener("click", sendEndTurn);
            //document.getElementById("RESET").addEventListener("click", resetButtonClicked);
            //document.getElementById("AUTO").addEventListener("click", playGameAutomagicallyInterval);
        };

        /*Prints Current Process to Screen*/
        function printGameOutput() {
            document.getElementById("GameOutput").innerHTML = control.getMessage();
        }

        /*Print Current Player Score for Turn*/
        function printPlayersScore(playerNameToPrint, toPrint) {
            document.getElementById(playerNameToPrint).innerText = playerNameToPrint + "'s score: " + toPrint;
            document.getElementById(playerNameToPrint).style.fontWeight = "bold";

            //current player is green background
            if (playerNameToPrint === players[control.getCurrentPlayerNumber()].getName()) {
                document.getElementById(playerNameToPrint).style.backgroundColor = "lightgreen";
            }
            else {
                //document.getElementById(playerNameToPrint).style.backgroundColor = "white";
                //document.getElementById(playerNameToPrint).style.backgroundColor = "red";
                var bgColor = new RGBA(0, 0, 255, (toPrint / PTW));
                document.getElementById(playerNameToPrint).style.backgroundColor = bgColor.getCSS();//(toPrint / scoreToWin);
            }
        }

        /*Get Current Player Turn Total*/
        function updateAccumulator() {
            document.getElementById("accumulatedValue").innerHTML = "Accumulated Value: " + control.getAccumulator();
        }

        /*Display Player Scores*/
        function printScores() {
            for (var x = 0; x < control.getNumberOfPlayers(); x++) {
                printPlayersScore(players[x].getName(), players[x].getScore())
            }
            var playerDivs = document.getElementById("PlayersDiv").children;
            playerDivs = Array.prototype.slice.call(playerDivs, 0);
            playerDivs.sort(function (a, b) {
                var val = -1;
                if (a.nodeName === "DIV" && b.nodeName === "DIV") {

                    //sort by player score value, (highest on top)s
                    val = ((b.innerHTML.split(":")[1]) - (a.innerHTML.split(":")[1]));
                }

                //in the event of a tie in score, sort by player alphabetically
                if (val == 0) {
                    return (b.innerText < a.innerText);
                }
                return val;
            });

            //internet taught me i forgot to remove and re-add elements... I'm not very bright
            var parent = document.getElementById('PlayersDiv');
            parent.innerHTML = "";

            for (var i = 0, l = playerDivs.length; i < l; i++) {
                parent.appendChild(playerDivs[i]);
            }

        }

        /*Update the Dice Display*/
        function updateDice() {
            var dice = control.getAllDice();
            var diceDiv = document.getElementById("Dice");
            diceDiv.innerHTML = "";
            for (var $d = 0; $d < control.getNumberOfDice(); $d++) {
                //var child = document.createElement("div");
                //child.style.width = "100px";
                //child.style.height = "100px";
                //child.float = "left";
                var image = document.createElement("img");
                image.src = "./Images/Dice" + dice[$d].getValue() + ".jpg";
                //child.appendChild(image);
                diceDiv.appendChild(image);
                //diceDiv.appendChild(child);
            }
        }

        function updateButtonAccess() {
            if (control.getAllPlayers()[control.getCurrentPlayerNumber()].getName() == preferredName) {
                document.getElementById("RD").disabled = false;
                document.getElementById("END").disabled = false;
            }
            else {
                document.getElementById("RD").disabled = true;
                document.getElementById("END").disabled = true;
            }
        }

        /*Roll Dice Game Button*/
        function rollDiceButtonClicked() {
            control.rollDice();
            printGameOutput();
            printScores();
            updateAccumulator();
            updateDice();
            updateButtonAccess();
        }

        /*End Turn Game Button*/
        function endTurnButtonClicked() {
            control.endTurn();
            printGameOutput();
            printScores();
            updateAccumulator();
            updateButtonAccess();
        }

        /*Auto Play Game Button*/
        function playGameAutomagically() {
            rollDiceButtonClicked();
            if (control.getAccumulator() > 0 && (Math.random() * 5 + 1) <= 4)
                endTurnButtonClicked();
        }

        /*Auto Play Game Button Specifications*/
        function playGameAutomagicallyInterval() {
            interval = setInterval(playGameAutomagically, 1);
        }

        /*Reset Game Button*/
        function resetButtonClicked() {
            control.resetGame();
            printGameOutput();
            printScores();
            updateAccumulator();
            clearInterval(interval);
        }

        /* Color Methods from Stack Overflow*/
        function RGBA(red, green, blue, alpha) {
            this.red = red;
            this.green = green;
            this.blue = blue;
            this.alpha = alpha;
            this.getCSS = function () {
                return "rgba(" + this.red + "," + this.green + "," + this.blue + "," + this.alpha + ")";
            }
        }

        function setBgOpacity(elem, opac) {
            bgColor.alpha = opac;
            elem.style.backgroundColor = bgColor.getCSS();
        }

        /*Public View Methods*/
        return {
            validateInput : validateInput,
            sendJoin : sendJoin
        }
    }; //end constructor

    /*Public View Instantiation*/
    return {
        init : init
    }

})();