// PolySnake V0.01
// Online snake game
// made with p5.js by @Github : leo-pnt


var grid;
var snake;
var apple;

let gamePaused = true;
let gameEnded = false; //monitor game state

let score = 0;

let screenRatio = 0.8;

function setup() {
    background(64, 149, 217);

    //set the canvas and modify css to match canvas size
    if(windowHeight > windowWidth) {
        var myCanvas = createCanvas(screenRatio*windowWidth, screenRatio*windowWidth);
        document.getElementById("gameBoard").style.width = (screenRatio*windowWidth).toString() + "px";
        document.getElementById("gameBoard").style.height = (screenRatio*windowWidth).toString() + "px";
    }
    else {
        var myCanvas = createCanvas(screenRatio*windowHeight, screenRatio*windowHeight);
        document.getElementById("gameBoard").style.width = (screenRatio*windowHeight).toString() + "px";
        document.getElementById("gameBoard").style.height = (screenRatio*windowHeight).toString() + "px";
    }
    myCanvas.parent("gameBoard");

    //the grid parameters
    let nbRow = 20;
    let nbCol = 20;    

    //the objects initialization
    grid = new Grid(nbRow, nbCol);
    snake = new Snake(4, 10, 15, width/nbRow, height/nbCol);
    apple = new Apple(nbRow, nbCol, width/nbRow, height/nbCol, snake.position);

    //set the speed/difficulty of the game
    //it's built according to framRate velocity
    frameRate(10);

    //game is paused by default
    document.getElementById("gametext").innerHTML = "press 'p' to pause/unpause the game | " + "game is paused...";
}

function draw() {
    background(64, 149, 217);
    
    
    //used to debug:
    //grid.display();
    
    
    if(snake.isColliding(grid.rowNb, grid.colNb)) {
        gamePaused = true;
        gameEnded = true;
        document.getElementById("gametext").innerHTML = "GAME OVER --> press 'f5' to reload";

        checkBestScore();
        noLoop();
    }

    if(!gamePaused) snake.autoMove();

    if(snake.checkAndEat(apple)) {
        score += 1;

        //update the score in html
        document.getElementById("score").innerHTML = "score: " + score.toString();
    }

    snake.display();
    apple.display();
}


function checkBestScore() {
    $.ajax({
        url: 'bestScore.php',
        type: 'post',
        data: { "score": score },
        
        /*used for debug:*/
        //success: function(response) { console.log(response); }
    });
}


//function called when a key is pressed on the keyboard
//it contain the key in the variable "keycode"
function keyPressed() {
    if (keyCode === UP_ARROW) {
        snake.playerMove(createVector(0, -1));
    }
    else if (keyCode === DOWN_ARROW) {
        snake.playerMove(createVector(0, 1));
    }
    if (keyCode === LEFT_ARROW) {
        snake.playerMove(createVector(-1, 0));
    }
    else if (keyCode === RIGHT_ARROW) {
        snake.playerMove(createVector(1, 0));
    }
  
}

//about same as above but with the variable "key"
function keyTyped() {
    if(key == "p") {
        gamePaused = !gamePaused;

        if(!gameEnded) {
            if(!gamePaused) {
                document.getElementById("gametext").innerHTML = "press 'p' to pause/unpause the game | " + "game is running...";
            }
            else {
                document.getElementById("gametext").innerHTML = "press 'p' to pause/unpause the game | " + "game is paused...";
            }
        }
    }
    if(key == "r" && gameEnded) {
        gameEnded = false;
        reloadGame();
    }
}
