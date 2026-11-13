f = open("TAJNOPIS2.txt", encoding="utf-8")
text = f.read().strip()[:267]
f.close()

# Count triplets of neighbouring letters
triplets = {}
for i in range(len(text) - 2):
    triplet = text[i] + text[i + 1] + text[i + 2]
    if triplet in triplets:
        triplets[triplet] = triplets[triplet] + 1
    else:
        triplets[triplet] = 1

sorted_triplets = sorted(triplets, key=triplets.get, reverse=True)
for triplet in sorted_triplets:
    print(triplet, triplets[triplet])

