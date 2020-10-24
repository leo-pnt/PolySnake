class Grid {
    //class used to construct to manage the background grid

    constructor(rowNb_, colNb_) {
        this.rowNb = rowNb_;
        this.colNb = colNb_;
        this.caseSizeX = (width) / (rowNb_);
        this.caseSizeY = (height) / (colNb_);
    }

    display() {
        push();
        noFill();
        noStroke();
        strokeWeight(1);
        stroke(0);

        
        //displays the board lines
        for(let r = 0; r <= this.rowNb; r++){
            for(let c = 0; c <= this.colNb; c++){
                rect(r * this.caseSizeX, c * this.caseSizeY, this.caseSizeX, this.caseSizeY);
            }
        }


        //displays the outer rectangle
        rect(0,0,this.rowNb * this.caseSizeX, this.colNb * this.caseSizeY);
        pop();
    }
}