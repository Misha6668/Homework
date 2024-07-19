mass = ['one', 'two', 'three', 'four']

def rev(arr):
    for i in range(len(arr) - 1, 0, -1):
        arr.remove(arr[i])
        arr.insert(0, arr[i])

    return arr


res = rev(mass)
print(res)