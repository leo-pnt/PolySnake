class Snake {
    constructor(length_, startingPosX, startingPosY, sizeX_, sizeY_) {
        this.sizeX = sizeX_;
        this.sizeY = sizeY_;
        
        //number of squares taken by snake:
        this.length = length_;
        
        //the position in pixel unit:
        this.position = [];
        
        for(let i = 0; i < this.length; i++) {
            //create a line starting snake:
            this.position.push(createVector(startingPosX, startingPosY +i));
        }
        
        //the position scaled:
        this.gridPos = []
        for(let i = 0; i < this.position.length; i++) {
            this.gridPos.push(createVector(
                this.position[i].x * this.sizeX,
                this.position[i].y * this.sizeY
            ));
        }
        
        //initial velocity is set here:
        //it moves in pixel unit
        this.velocity = createVector(0, -1);
    }

    display() {
        push();
        noStroke();
        fill(255, 255, 255);
        //the head:
        rect(this.gridPos[0].x, this.gridPos[0].y,this.sizeX,this.sizeY);

        //the body:
        for(let i = 1; i < this.gridPos.length; i++) {
            //apply a gradient color on the snake:
            fill(255, 255, 255, map(i, 0, this.gridPos.length -1, 255, 155));

            rect(this.gridPos[i].x, this.gridPos[i].y, this.sizeX, this.sizeY);
        }
        pop();
    }


    autoMove() {
        /*
        we check if there is a backward move
        if so, we add the opposite velocity copenants
        */

        if(this.position[0].copy().x + this.velocity.copy().x != this.position[1].x
        || this.position[0].copy().y + this.velocity.copy().y != this.position[1].y) {

            //each position except the head is shifted to its future position
            for(let i = this.position.length - 2; i >= 0; i--) {
                this.position[i+1] = this.position[i].copy();
            }
        
            //then the head is moved
            this.position[0].x += this.velocity.x;
            this.position[0].y += this.velocity.y;

            
        }
        else {
            //each position except the head is shifted to its future position
            for(let i = this.position.length - 2; i >= 0; i--) {
                this.position[i+1] = this.position[i].copy();
            }

            //this is where we add the opposite velocity
            //so if the velocity make the snake go backwards, he will not
            this.position[0].x -= this.velocity.x;
            this.position[0].y -= this.velocity.y;

        }

        //then we update the gridPos
        //it's the scaled position 
        for(let i = 0; i < this.gridPos.length; i++) {
            this.gridPos[i].x = this.position[i].x * this.sizeX;
            this.gridPos[i].y = this.position[i].y * this.sizeY;
        }
    }

    isColliding(nbRow, nbCol) {
        //check collision with borders
        if(this.position[0].x < 0 || this.position[0].x >= nbRow){
            return true;
        }
        if(this.position[0].y < 0 || this.position[0].y >= nbCol) {
            return true;
        }
        for(let i = 3; i < this.position.length; i++) {
            
            //check if collide with itself
            //note that it start at 3 because the snake can't touch it's own head
            //but also the 2 following squares
            if(this.position[0].equals(this.position[i])) {
                return true;
            }
        }

        return false;
    }

    playerMove(dirUnitVect) {
        /* this function is called on the keyPressed() event */

        //to improve feeling/speed sensatin the gridPos is directly moved:
        //TODO: check if it is really necessary
        this.gridPos.x += dirUnitVect.x;
        this.gridPos.y += dirUnitVect.y;
        

        //the true move:
        this.adjustVelocity(dirUnitVect);
    }

    adjustVelocity(dirUnitVect) {
        //should be called only in playerMove
        //to avoid cheating we normalize the vector:
        dirUnitVect.normalize();
        dirUnitVect.setMag(this.velocity.mag());

        this.velocity = dirUnitVect;
    }

    checkAndEat(apple) {
        //if head overlap apple position:
        if(this.position[0].equals(apple.position)) {
            //give a new position to the apple
            apple.spawn(this.position);

            //increase snake length
            this.length += 1;
            //add an element to the tail
            this.position.push(this.position[this.position.length -1]);

            //update the gridPos:
            this.gridPos.push(createVector(
                this.position[this.position.length -1].x * this.sizeX,
                this.position[this.position.length -1].y * this.sizeY
            ));

            //there is a return statement to increase the score in
            //the draw() function
            return true;
        }

        return false;
    }
}