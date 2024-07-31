def calculate_average(numbers):
    total = 0
    for num in numbers:
        total += num
    return total / len(numbers)

numbers = [1, 2, 3, 4, 5]
print(calculate_average(numbers))