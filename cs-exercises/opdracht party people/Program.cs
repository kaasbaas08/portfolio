using System;
using System.Collections.Generic;
using System.IO;
using Newtonsoft.Json;

class Program
{
    static void Main(string[] args)
    {
        try
        {
            // Zorg ervoor dat je het juiste pad naar je JSON-bestand hebt
            string path = "people.json";
            if (!File.Exists(path))
            {
                Console.WriteLine($"The file '{path}' was not found.");
                return;
            }

            // Lees het JSON-bestand in
            string json = File.ReadAllText(path);

            // Deserialiseer het JSON-bestand naar een lijst van Person objecten
            List<Person>? people = JsonConvert.DeserializeObject<List<Person>>(json);

            if (people == null)
            {
                Console.WriteLine("No people found in the JSON file.");
                return;
            }

            // Toon de introductie van alle personen
            foreach (var person in people)
            {
                Console.WriteLine(person.Introduce());
            }
        }
        catch (Exception e)
        {
            Console.WriteLine("An error occurred: " + e.Message);
        }
    }
}
