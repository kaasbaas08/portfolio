
public class Person
{
    public string? FirstName { get; set; }
    public string? LastName { get; set; }
    public int Age { get; set; }

    public string Introduce()
    {
        return $"Hi, I am {FirstName ?? "Unknown"} {LastName ?? "Unknown"} and I am {Age} years old.";
    }
}
