using System;
class Roulette
{
    static void Main(string[] args)
    {
        int chips = 10;
        Console.WriteLine("Welcome to the Rien ne va plus! You have " + chips + " chips. Good luck!");
        Console.WriteLine("Enter a number between 0 and 36 or 'stop' to try your luck!");
        Console.WriteLine("Place your bets!");
        chips = gameStart();
    }

    static int gameStart()
    {
        int chips = 10; // Initialize the chips variable
        int random = new Random().Next(0, 37);
        while (chips > 0)
        {
            bool isRunning = true;
            while (isRunning)
            {
                Console.WriteLine("Enter a number between 1 and 36 or 'stop' to exit:");
                string input = Console.ReadLine();

                if (input.Equals("stop", StringComparison.OrdinalIgnoreCase))
                {
                    Console.WriteLine("rien ne va plus!");
                    isRunning = false;
                }
                else
                {
                    if (int.TryParse(input, out int number))
                    {
                        if (number >= 0 && number <= 36)
                        {
                            if (number == random)
                            {
                                chips += 35;
                            }
                            else
                            {
                                chips -= 1;
                                if (chips == 0)
                                {
                                    break;
                                }
                            }
                        }
                        else
                        {
                            Console.WriteLine("Invalid input. Please enter a valid number between 0 and 36.");
                        }
                    }
                    else
                    {
                        Console.WriteLine("Invalid input. Please enter a valid number or 'stop'.");
                    }
                }
            }
            break;
        }
        Console.WriteLine("GAME OVER");
        Console.WriteLine("The number was:" + random);
        Console.WriteLine("You have " + chips + " chips left. Goodbye!"); // Fix typo in Console.WriteLine
        return chips;
    }
}