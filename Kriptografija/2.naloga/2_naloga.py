# Define all 5 variables from the assignment
m = 256
modulus = 2**m
a = 41893710582916482957102948175920394817562938471059283749102938475610293847561
b = 85940291847561029384756102938475610293847561029384756102938475610293847561029
x = 73920184756102938475610293847561029384756102938475610293847561029384756102938
y = 97027352668494957527005057170802690953915886851401238714997311796854899989971

# 1. SOLUTION: Find the second preimage (using only a, x, and modulus)
x_2 = (-a - x) % modulus

# Output the answer to the screen
print("Your answer (second preimage):")
print(x_2)
print("-" * 30)

# 2. VERIFICATION: Substitute the found answer into the full formula (using b and y)
# Calculate: (x_2 squared + a * x_2 + b) modulo modulus
y_check = (x_2**2 + a * x_2 + b) % modulus

print("Verification:")
if y_check == y:
    print("Success! Substituting this new x into the formula yields the correct y.")
else:
    print("There is an error somewhere.")
