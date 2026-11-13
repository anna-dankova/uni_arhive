f = open("TAJNOPIS2.txt", encoding="utf-8")
text = f.read().strip()
f.close()

# Count pairs of neighbouring letters
pairs = {}
for i in range(len(text) - 1):
    pair = text[i] + text[i + 1]
    if pair in pairs:
        pairs[pair] = pairs[pair] + 1
    else:
        pairs[pair] = 1

sorted_pairs = sorted(pairs, key=pairs.get, reverse=True)
for pair in sorted_pairs[0:10]:
    print(pair, pairs[pair])