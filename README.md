# Codebreaker Kata

## Description

Codebreaker is a logic game in which a code-breaker tries to break a secret code created by a code-maker. The code-maker, which will be played by the application we’re going to write, creates a secret code of four numbers between 1 and 6.

The code-breaker then gets 10 chances to break the code. In each turn, the code-breaker makes a guess of four numbers (again, 1 to 6). The code-maker then marks the guess with up to four + and - signs.

A + indicates an exact match: one of the numbers in the guess is the same as one of the numbers in the secret code and in the same position.

A - indicates a number match: one of the numbers in the guess is the same as one of the numbers in the secret code but in a different position.

For example, given a secret code 1234, a guess with 4256 would earn a +-. The + is for the 2 in the second position in the guess, which matches the 2 in the secret code in both number and position: an exact match. The - is for the 4 in the first position in the guess, which matches the 4 in the code but not in the same position: a number match.

The plus signs for the exact matches always come before the minus signs for the number matches and don’t align with specific positions in the guess or the secret code.

Please add validation of guesses and a way for the code-breaker to quit the game.

To test your implementation use this examples:

| secret | guess | output |
| ------ | ----- | ------ |
| 1234   | 4256  | +-     |
| 3435   | 3445  | +++    |
| 4342   | 1122  | +      |
| 2314   | 3434  | +-     |

## Development

To create the developer environment run

```bash
cp .env .env.dist
docker-compose build
docker-compose up -d
```

To enter into the development container's shell run

```bash
docker-compose run app bash
```



Inversion of Control
Modules are coupled if changing one of them requires changing another one
tight coupling - loose coupling
A has an attribute that refers to B
A calls a method on B
A extends or implements B

service container
