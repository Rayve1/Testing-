import unittest
from calculated import add, multiply, subtract, divide

class TestCalculator(unittest.TestCase):
   def test_addition(self):
       self.assertEqual(add(3, 5), 8)

   def test_multiplication(self):
       self.assertEqual(multiply(4, 6), 24)

   def test_subtraction(self):
       self.assertEqual(subtract(7, 3), 4)

   def test_division_with_zero(self):
       with self.assertRaises(ZeroDivisionError):
           divide(10, 0)

   def test_division(self):
       self.assertEqual(divide(20, 5), 4)

if __name__ == "__main__":
    unittest.main(exit=False)