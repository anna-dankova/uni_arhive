# Read the ciphertext
f = open("TAJNOPIS2.txt", encoding="utf-8")
text = f.read().strip()
f.close()

# Count each letter
counts = {}
for letter in text:
    if letter in counts:
        counts[letter] = counts[letter] + 1
    else:
        counts[letter] = 1

# Take the 4 most frequent letters
sorted_letters = sorted(counts, key=counts.get, reverse=True)
top4 = sorted_letters[0:4]

# Add their counts together
sum_top4 = 0
for letter in top4:
    print(letter, counts[letter])
    sum_top4 = sum_top4 + counts[letter]

# Percent of the whole text
percent = sum_top4 / len(text) * 100
print("Top 4 letters:", top4)
print("Together:", sum_top4, "of", len(text))
print("Percent:", percent)