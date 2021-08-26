import { checkBoard } from "./assets/checkBoard.js"
import { computer } from "./assets/computer.js"
import { put } from "./assets/put.js"

let settings = document.querySelector('#settings')
let start = document.querySelector('#start')
let countinue = document.querySelector('#continue')
let continuelist = document.querySelector('#continuelist')
let type = document.querySelectorAll('input[name=type]')

let removable = document.querySelector('#removable')
let player1 = document.querySelector('#player1')
let player2 = document.querySelector('#player2')
let saveName = document.querySelector('#name')

let rules = document.querySelector('#rules')
let rulSet = document.querySelector('#ruleset')

let gameChanges = document.querySelector('#gamechanges')
let backToMenu = document.querySelector('#backToMenu')
let reset = document.querySelector('#reset')
let save = document.querySelector('#save')
let players = document.querySelector('.players')
let colums = document.querySelectorAll('.board')

let twoPlayer = false
let listenToKeyBoard = false
let rulesVisible = false
let won = false
let countinuesVisible = false
let redsTurn = true



let red = 1
let yellow = 2
let games = []

let board = new Array(0, 0, 0, 0, 0, 0, 0);
board[0] = new Array(0, 0, 0, 0, 0, 0);
board[1] = new Array(0, 0, 0, 0, 0, 0);
board[2] = new Array(0, 0, 0, 0, 0, 0);
board[3] = new Array(0, 0, 0, 0, 0, 0);
board[4] = new Array(0, 0, 0, 0, 0, 0);
board[5] = new Array(0, 0, 0, 0, 0, 0);
board[6] = new Array(0, 0, 0, 0, 0, 0);

let height = new Array(5, 5, 5, 5, 5, 5, 5);

for (let i = 0; i < type.length; i++) {
    type[i].addEventListener('click', () => {
        twoPlayer = type[i].value == "true" ? true : false
        if (twoPlayer) {
            removable.classList.remove('hidden')
            rulSet.classList.add('hidden')
            rulesVisible = !rulesVisible
        } else {
            removable.classList.add('hidden')
        }
    })
}

export { board, height, red, yellow }


start.addEventListener('click', () => {
    startGame(twoPlayer)
})

countinue.addEventListener('click', () => {
    if (!countinuesVisible) {
        continuelist.classList.remove('hidden')
        countinuesVisible = true
    }
    else {
        continuelist.classList.add('hidden')
        countinuesVisible = false
    }
})

saveName.addEventListener('click', () => {
    addPlayerName(player1.value, player2.value)

})

rules.addEventListener('click', () => {
    if (!rulesVisible) {
        rulSet.classList.remove('hidden')
    } else {
        rulSet.classList.add('hidden')
    }
    rulesVisible = !rulesVisible
})

backToMenu.addEventListener('click', () => {
    settings.classList.remove('hidden')
    gameChanges.classList.add('hidden')
    resetBoard()
    redsTurn = true
    won = false
})

reset.addEventListener('click', () => {
    resetBoard()
    redsTurn = true
    won = false
})

save.addEventListener('click', () => {

    const game = new Object()
    game.name = player1.value + " vs " + player2.value
    game.player1 = player1.value
    game.player2 = player2.value
    game.type = twoPlayer
    game.board = board
    game.height = height
    game.show = document.getElementById("boarsdAddCoin").innerHTML
    games.push(game)
    localStorage.setItem('myStorage', JSON.stringify(games))
    let savedGames = JSON.parse(localStorage.getItem('myStorage'))

    continuelist.innerHTML = ''
    for (let i = 0; i < savedGames.length; i++) {
        const savedGame = savedGames[i]
        const continueGame = document.createElement('button')
        continuelist.appendChild(continueGame)
        if (savedGame.type) continueGame.innerHTML = savedGame.name
        else continueGame.innerHTML = "Player vs Computer"
        const linebreak = document.createElement('br')
        continuelist.appendChild(linebreak)

        continueGame.addEventListener('click', () => {
            addPlayerName(savedGame.player1, savedGame.player2)
            board = savedGame.board
            height = savedGame.height
            twoPlayer = savedGame.type
            document.getElementById("boarsdAddCoin").innerHTML = savedGame.show
            startGame(savedGame.type)
        })
    }
})

window.addEventListener('keyup', (e) => {
    let value = parseInt(e.key)
    if (listenToKeyBoard && value > 0 && value < 8) {
        addCoin(value - 1)
    }
})


for (let i = 0; i < colums.length; i++) {
    colums[i].addEventListener('click', () => {
        addCoin(i)
    })
}

export function resetBoard() {
    board = board.map(i => i.map(e => e = 0))
    height = height.map(x => x = 5)
    document.getElementById("boardsAddCoin").innerHTML = ''
}

function addPlayerName(plyer1, plyer2) {
    players.innerHTML = ''
    const playername1 = document.createElement('h1')
    const playername2 = document.createElement('h1')
    players.appendChild(playername1)
    players.appendChild(playername2)

    playername1.innerHTML = plyer1 + "<img src='./assets/red-circle.gif' width=20 height = 20>"
    playername2.innerHTML = "<img src='./assets/yellow-circle.gif' width=20 height = 20>" + plyer2
    playername1.className = "player1label"
    playername2.className = "player2label"

}
function startGame(numPlayers) {
    settings.classList.add('hidden')
    gameChanges.classList.remove('hidden')
    listenToKeyBoard = true
    if (!numPlayers) {
        players.innerHTML = ''
    }
    rulSet.classList.add('hidden')
    continuelist.classList.add('hidden')
    countinuesVisible = false
}

function addCoin(column) {
    let coinColor = red
    let player = player1.value
    if (!redsTurn) {
        coinColor = yellow
        player = player2.value
    }
    if (height[column] == -1)
        alert("column full")
    else {
        board[column][height[column]] = coinColor
        height[column] = height[column] - 1
        put(column, coinColor)
        if (checkBoard(column, height[column] + 1, 4, coinColor, false) == true) {
            won = true
            if (twoPlayer) alert(player + " wins")
            else alert("You win")
            resetBoard()
        }
        if (
            (height[0] == -1) &&
            (height[1] == -1) &&
            (height[2] == -1) &&
            (height[3] == -1) &&
            (height[4] == -1) &&
            (height[5] == -1) &&
            (height[6] == -1)) {
            alert("Draw Game")

            resetBoard()
        }
        if (twoPlayer) redsTurn = !redsTurn
        else if (won != true) computer()
    }
}