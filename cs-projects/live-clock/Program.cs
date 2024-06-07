using System;
using System.Threading.Tasks;
using System.Net.Http;
using System.Linq;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;

class Clock
{
    static async Task Main()
    {
        Console.WriteLine("Enter your city name: ");
        string cityName = Console.ReadLine();

        DateTime now = DateTime.Now;

        Console.WriteLine("Current Date and Time: " + now.ToString("yyyy-MM-dd HH:mm:ss"));

        await GetCoordinates(cityName);
        await GetWeather(cityName);
    }

    static async Task<(double, double)?> GetCoordinates(string cityName)
    {
        string apiKey = "70863d27c8f4f659ca7b419fd7462069";
        string url = $"https://api.openweathermap.org/geo/1.0/direct?q={cityName}&limit=1&appid={apiKey}";

        using HttpClient client = new HttpClient();
        var response = await client.GetStringAsync(url);
        var locationData = JToken.Parse(response);

        if (locationData.Count() > 0)
        {
            double latitude = (double)locationData[0]["lat"];
            double longitude = (double)locationData[0]["lon"];
            return (latitude, longitude);
        }
        else
        {
            return null;
        }
    }

    static async Task GetWeather(string cityName)
    {
        var coordinates = await GetCoordinates(cityName);
        if (coordinates != null)
        {
            double latitude = coordinates.Value.Item1;
            double longitude = coordinates.Value.Item2;

            string url = $"https://api.open-meteo.com/v1/forecast?latitude={latitude}&longitude={longitude}&current_weather=true";

            using HttpClient client = new HttpClient();
            var response = await client.GetStringAsync(url);
            var weatherData = JObject.Parse(response);

            var currentWeather = weatherData["current_weather"];
            if (currentWeather != null)
            {
                double temperature = (double)currentWeather["temperature"];
                string weather = (string)currentWeather["weathercode"];

                Console.WriteLine($"Temperature: {temperature}°C");
                Console.WriteLine($"Weather Description: {weather}");
            }
            else
            {
                Console.WriteLine("Weather data not available.");
            }
        }
        else
        {
            Console.WriteLine("Coordinates not found for the specified city.");
        }
    }
}
