import { board, height, red, yellow, resetBoard } from "../c4.js"
import { checkBoard, empty } from "./checkBoard.js"
import { put } from "./put.js"


export function computer() {
    let x, i, j, k
    let column
    let count
    let chance = new Array(0, 0, 0, 0, 0, 0, 0)

    chance[0] = 13 + Math.random() * 4
    chance[1] = 13 + Math.random() * 4
    chance[2] = 16 + Math.random() * 4
    chance[3] = 16 + Math.random() * 4
    chance[4] = 16 + Math.random() * 4
    chance[5] = 13 + Math.random() * 4
    chance[6] = 13 + Math.random() * 4

    for (i = 0; i <= 6; i++) {
        if (height[i] < 0)
            chance[i] = chance[i] - 30000
    }

    for (i = 0; i <= 6; i++) {
        if (checkBoard(i, height[i], 3, yellow, false) == true) chance[i] = chance[i] + 20000

        if (checkBoard(i, height[i], 3, red, false) == true) chance[i] = chance[i] + 10000

        if (checkBoard(i, height[i] - 1, 3, red, false) == true) chance[i] = chance[i] - 4000

        if (checkBoard(i, height[i] - 1, 3, yellow, false) == true) chance[i] = chance[i] - 200

        if (checkBoard(i, height[i], 2, red, false) == true) chance[i] = chance[i] + 50 + Math.random() * 3

        if ((checkBoard(i, height[i], 2, yellow, true) == true) && (height[i] > 0)) {
            board[i][height[i]] = yellow
            height[i]--
            count = 0
            for (j = 0; j <= 6; j++) if (checkBoard(j, height[j], 3, yellow, false) == true) count++
            if (count == 0) { chance[i] = chance[i] + 60 + Math.random() * 2 } else { chance[i] = chance[i] - 60 }
            height[i]++
            board[i][height[i]] = empty
        }


        if (checkBoard(i, height[i] - 1, 2, red, false) == true) chance[i] = chance[i] - 10

        if (checkBoard(i, height[i] - 1, 2, yellow, false) == true) chance[i] = chance[i] - 8

        if (checkBoard(i, height[i], 1, red, false) == true) chance[i] = chance[i] + 5 + Math.random() * 2

        if (checkBoard(i, height[i], 1, yellow, false) == true) chance[i] = chance[i] + 5 + Math.random() * 2


        if (checkBoard(i, height[i] - 1, 1, red, false) == true) chance[i] = chance[i] - 2


        if (checkBoard(i, height[i] - 1, 1, yellow, false) == true) chance[i] = chance[i] + 1


        if ((checkBoard(i, height[i], 2, yellow, true) == true) && (height[i] > 0)) {
            board[i][height[i]] = yellow
            height[i]--
            for (k = 0; k <= 6; k++)
                if ((checkBoard(k, height[k], 3, yellow, false) == true) && (height[k] > 0)) {
                    board[k][height[k]] = red
                    height[k]--
                    for (j = 0; j <= 6; j++)
                        if (checkBoard(j, height[j], 3, yellow, false) == true) chance[i] = chance[i] + 2000
                    height[k]++
                    board[k][height[k]] = empty
                    }
            height[i]++
            board[i][height[i]] = empty
        }

        if ((checkBoard(i, height[i], 2, red, true) == true) && (height[i] > 0)) {
            board[i][height[i]] = red
            height[i]--
            for (k = 0; k <= 6; k++)
                if ((checkBoard(k, height[k], 3, red, false) == true) && (height[k] > 0)) {
                    board[k][height[k]] = yellow
                    height[k]--
                    for (j = 0; j <= 6; j++)
                        if (checkBoard(j, height[j], 3, red, false) == true) chance[i] = chance[i] + 1000
                    height[k]++
                    board[k][height[k]] = empty
                }
            height[i]++
            board[i][height[i]] = empty
        }


        if ((checkBoard(i, height[i] - 1, 2, red, true) == true) && (height[i] > 1)) {
            board[i][height[i]] = red
            height[i]--
            for (k = 0; k <= 6; k++)
                if ((checkBoard(k, height[k] - 1, 3, red, false) == true) && (height[k] > 0)) {
                    board[k][height[k]] = yellow
                    height[k]--
                    for (j = 0; j <= 6; j++)
                        if (checkBoard(j, height[j] - 1, 3, red, false) == true) chance[i] = chance[i] - 500
                    height[k]++
                    board[k][height[k]] = empty
                }
            height[i]++
            board[i][height[i]] = empty
        }

    }

    column = 0
    x = -10000
    for (i = 0; i <= 6; i++)
        if (chance[i] > x) {
            x = chance[i]
            column = i
            console.log(column+1,"\n",x);
        }

    board[column][height[column]] = yellow
    height[column] = height[column] - 1
    put(column, yellow)
    if (checkBoard(column, height[column] + 1, 4, yellow, false) == true) {
        alert("You have lost")
        resetBoard()
    }
    if ((height[0] == -1) && (height[1] == -1) && (height[2] == -1) && (height[3] == -1) && (height[4] == -1) && (height[5] == -1) && (height[6] == -1)) {
        alert("Draw game")
        resetBoard()
    }
}