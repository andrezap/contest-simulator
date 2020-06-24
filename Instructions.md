# InnoGames Singing Contest Simulator

## Introduction

For this coding challenge, please provide a PHP-based solution with a relational database (e.g. MySQL) for the problem outlined below. The focus should be on clean coding principles, and the end result need not contain a "pretty" frontend. Feel free to use any third-party libraries or frameworks to assist you in however you need to complete this in a timely manner. Please send either a zip of your final package including database schema or a link to your GitHub project as delivery. Good luck!

## Project Outline

For this coding challenge, please create a small game that can simulate a singing contest. The contest will be created by the click of a button, and this button will then change to progress the contest through a series of six rounds. When creating the contest, a set of ten contestants and three judges will be randomly generated. The progress button will then step through the set of rounds until one lucky contestant is crowned the winner. There should only ever be a single contest at any one time, until the six rounds of the current have been completed.

A second view in the project will show the player a history of the last five contest winners and their final scores. The top scoring contestant of all time should also be displayed in this view.

### Rounds

Each round will be a genre of music. The six to choose from are: `Rock`, `Country`, `Pop`, `Disco`, `Jazz` and `The Blues`. The order of rounds should be randomized during contest creation, but each genre should be in the contest exactly once (no duplicates). Each contestant will have different strengths in each genre that will affect their result. During each round, each contestant's genre rating is multiplied by a random single-decimal place float between 0.1 and 10.0, and this score is used by each judge to give each contestant a final judge's score for the round. After the six rounds are completed, the contestant with the highest total judge score is crowned the winner and recorded for historical purposes. In the event of a tie, each contestant is rewarded with this achievement.

### Contestants

The ten contestants are randomly generated during contest creation. They have a random integer strength score for each of the six genres that ranges from 1 to 10. During each round, the contestant's calculated score is therefore ranging from 0.1 to 100.0, as outlined in the *Rounds* section above. This calculated contestant score is converted by each of the three selected judges in order to determine the contestant's judge's score. The total of the three judges' scores across each of the six rounds is used to determine the winner of the contest.

There is also a 5% chance that a contestant will become sick during any round. If the contestant is flagged as being sick during the round, their calculated contestant score is halved before the judges calculate their round score. The calculated contestant score should be rounded to one significant decimal place (rounding up) so the minimum score (even when sick) should still be 0.1.

### Judges

There are a total of five judges, but only three are in each contest, randomly selected during contest creation. Each judge is unique and has their own method for scoring based on the calculated score from a contestant in any given round. All judge's scores are integer values from 0 to 10, thus each round a contestant gets a total judges' score out of 30 as an integer.

- `RandomJudge`: This judge gives a random score out of 10, regardless of the calculated contestant score.
- `HonestJudge`: This judge converts the calculated contestant score evenly using the following table:
		||Calculate Score Range||Judge Score||
		|     0.1 - 10.0        |      1     |
		|    10.1 - 20.0        |      2     |
		|    20.1 - 30.0        |      3     |
		|    30.1 - 40.0        |      4     |
		|    40.1 - 50.0        |      5     |
		|    50.1 - 60.0        |      6     |
		|    60.1 - 70.0        |      7     |
		|    70.1 - 80.0        |      8     |
		|    80.1 - 90.0        |      9     |
		|    90.1 - 100.0       |     10     |
- `MeanJudge`: This judge gives every contestant with a calculated contestant score less than 90.0 a judge score of 2. Any contestant scoring 90.0 or more instead receives a 10.
- `RockJudge`: This judge's favourite genre is `Rock`. For any other genre, the `RockJudge` gives a random integer score out of 10, regardless of the calculated contestant score. For the `Rock` genre, this judge gives a score based on the calculated contestant score - less than 50.0 results in a judge score of 5, 50.0 to 74.9 results in an 8, while 75 and above results in a 10.
- `FriendlyJudge`: This judge gives every contestant a score of 8 unless they have a calculated contestant score of less than or equal to 3.0, in which case the `FriendlyJudge` gives a 7. If the contestant is sick, the `FriendlyJudge` awards a bonus point, regardless of calculated contestant score.

