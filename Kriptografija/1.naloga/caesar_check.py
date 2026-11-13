# Slovenian ciphertext alphabet
ALPHABET_25 = "ABCČDEFGHIJKLMNOPRSŠTUVZŽ"
ALPHABET_24 = ALPHABET_25.replace("Š", "")

with open("TAJNOPIS2.txt", encoding="utf-8") as f:
    t = f.read().strip()

print("Length:", len(t))
print("Unique characters:", len(set(t)))
print("Count of Š:", t.count("Š"))

for alphabet in (ALPHABET_25, ALPHABET_24):
    n = len(alphabet)
    print()
    print("Alphabet of", n, "letters:", alphabet)

    for shift in range(n):
        result = ""
        for ch in t:
            i = alphabet.index(ch)
            result += alphabet[(i - shift) % n]
        print(shift, result)
