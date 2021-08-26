import { board, height, red, yellow } from "../c4.js"

let empty = 0
let outOfBounds = 3

export { empty }
function get(column, row) {
    if ((column < 0) || (column > 6) || (row < 0) || (row > 5)) {
        return outOfBounds
    }
    else {
        return (board[column][row])
    }
}

export function checkBoard(x, y, amount, color, checkBoard_bei_2) {
    let j, k
    let sum1, sum2, sum3, sum4
    let sum12, sum22, sum32, sum42
    let color2
    let anyoneWinning = false

    if (color == red) {
        color2 = yellow
    } else {
        color2 = red
    }

    for (k = 0; k <= 3; k++) {
        sum1 = 0
        sum2 = 0
        sum3 = 0
        sum4 = 0
        sum12 = 0
        sum22 = 0
        sum32 = 0
        sum42 = 0

        for (j = 0; j <= 3; j++) {
            if (get(x - k + j, y) == color) { sum1++ }
            if (get(x, y - k + j) == color) { sum2++ }
            if (get(x - k + j, y - k + j) == color) { sum3++ }
            if (get(x + k - j, y - k + j) == color) { sum4++ }
            if (get(x - k + j, y) == color2) { sum12++ }
            if (get(x, y - k + j) == color2) { sum22++ }
            if (get(x - k + j, y - k + j) == color2) { sum32++ }
            if (get(x + k - j, y - k + j) == color2) { sum42++ }
            if (get(x - k + j, y) == outOfBounds) { sum12++ }
            if (get(x, y - k + j) == outOfBounds) { sum22++ }
            if (get(x - k + j, y - k + j) == outOfBounds) { sum32++ }
            if (get(x + k - j, y - k + j) == outOfBounds) { sum42++ }
        }
        if ((sum1 >= amount) && (sum12 == 0)) { anyoneWinning = true } else
            if ((sum2 >= amount) && (sum22 == 0)) { anyoneWinning = true } else
                if ((sum3 >= amount) && (sum32 == 0)) { anyoneWinning = true } else
                    if ((sum4 >= amount) && (sum42 == 0)) anyoneWinning = true

        if ((anyoneWinning == true) && (checkBoard_bei_2 == true)) {
            sum12 = 0
            sum22 = 0
            sum32 = 0
            sum42 = 0
            board[x][y] = color
            height[x]--

            for (j = 0; j <= 3; j++) {
                if ((sum1 >= amount) && (get(x - k + j, y) == empty) && (get(x - k + j, height[x - k + j] + 1) == empty)) sum12++
                if ((sum2 >= amount) && (get(x, y - k + j) == empty) && (get(x, height[x] + 1) == empty)) sum22++
                if ((sum3 >= amount) && (get(x - k + j, y - k + j) == empty) && (get(x - k + j, height[x - k + j] + 1) == empty)) sum32++
                if ((sum4 >= amount) && (get(x + k - j, y - k + j) == empty) && (get(x + k - j, height[x + k - j] + 1) == empty)) sum42++
            }
            if ((sum12 == 1) || (sum22 == 1) || (sum32 == 1) || (sum42 == 1)) anyoneWinning = false
            height[x]++
            board[x][y] = empty
        }
    }
    return anyoneWinning
}