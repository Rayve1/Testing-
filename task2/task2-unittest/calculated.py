def add( x1, x2):
    return x1 + x2

def multiply( x1, x2):
    return x1 * x2

def subtract(x1, x2):
    return x1 - x2

def divide( x1, x2):
    if x2 == 0:
        raise ZeroDivisionError("division by zero")
    return x1 / x2
