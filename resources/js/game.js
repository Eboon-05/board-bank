import "./app";

console.log(game, `game.${game.id}`)

const channel = Echo.channel(`game.${game.id}`)

console.log(channel)

channel.listen("BankTransaction", (e) => {
    alert("Hello from game.js!");
    console.log(e);
});
