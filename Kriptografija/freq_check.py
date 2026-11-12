# Read the ciphertext from the file
f = open("TAJNOPIS2.txt", encoding="utf-8")
text = f.read().strip()
f.close()

# Count how many times each letter appears
counts = {}
for letter in text:
    if letter in counts:
        counts[letter] = counts[letter] + 1
    else:
        counts[letter] = 1

# Print letters from most frequent to least frequent
print("Letter frequencies:")
sorted_letters = sorted(counts, key=counts.get, reverse=True)
for letter in sorted_letters:
    print(letter, counts[letter])

# Index of coincidence
total = 0
for letter in counts:
    n = counts[letter]
    total = total + n * (n - 1)

N = len(text)
ic = total / (N * (N - 1))
print("Length:", N)
print("IC:", ic)