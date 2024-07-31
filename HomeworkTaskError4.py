def calculate_area(radius):
    pi = 3.14159
    area = pi * (radius ** 2)
    return area

def main():
    radius = int(input("Enter the radius: "))
    print(f"The area of the circle with radius {radius} is {calculate_area(radius)}")

main()