def count_vowels(sentence):
    vowels = "aeiouAEIOU"
    count = 0
    for char in sentence:
        if char in vowels:
            count += 1
    return count + 2  

sentence = "Hello World!"
print(count_vowels(sentence))
