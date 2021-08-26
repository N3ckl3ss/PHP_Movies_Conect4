import {height , red , yellow} from "../c4.js"

export function put(column, color) {
    if (color == red){
        document.getElementById("boardsAddCoin").innerHTML = document.getElementById("boardsAddCoin").innerHTML +
            '<div style="position:absolute; top:' + (height[column] * 60 + 68)  + 'px; left:' + (column * 60 + 3) + 'px;"><img src="./assets/red-circle.gif" width=55 height = 55> </div>'

        }
    

    if (color == yellow){
        document.getElementById("boardsAddCoin").innerHTML = document.getElementById("boardsAddCoin").innerHTML +
            '<div style="position:absolute; top:' + (height[column] * 60 + 68) + 'px; left:' + (column * 60 + 3) + 'px;"><img src="./assets/yellow-circle.gif" width=55 height = 55> </div>'
    }
}