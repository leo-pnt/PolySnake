class Apple {
    constructor(GridnbRow, GridnbCol, sizeX_, sizeY_, snakePos) {
        this.sizeX = sizeX_;
        this.sizeY = sizeY_;
        this.gridNbRow = GridnbRow;
        this.gridNbCol = GridnbCol;

        this.spawn(snakePos);
    }

    display() {
        push();
        //fill(64, 255, 230);
        fill(255);
        noStroke();
        ellipseMode(CORNER);
        //rect(this.gridPos.x, this.gridPos.y, this.sizeX, this.sizeY);
        ellipse(this.gridPos.x, this.gridPos.y, this.sizeX, this.sizeY);
        pop();
    }

    spawn(snakePos) {
        //the spawn needs snakePos in order to not spawn on the snake
        //if the random position is on the snake, we generate an other position
        //until it's ok:
        do {
            this.position = createVector(round(random(0, this.gridNbRow -1)), round(random(0, this.gridNbCol -1)));
            this.gridPos = createVector(this.position.x * this.sizeX, this.position.y * this.sizeY);
        } while(this.isOnSnake(snakePos));
    }

    isOnSnake(snakePos) {
        //the check is made to avoid spawing the apple on the snake
        for(let i = 0; i < snakePos.length; i++) {
            if(this.position.equals(snakePos[i])){
                return true;
            }
        }

        return false;
    }

}