class BankAccount:
    def __init__(self, account_number, balance=0):
        self.account_number = account_number
        self.__balance = balance  

    def deposit(self, amount):
        if amount < 0:  
            raise ValueError("Deposit amount cannot be negative")
        self._balance += amount  

    def get_balance(self):
        return self.__balance  # Should be _balance instead of __balance (private variable)

account = BankAccount(1234, 1000)
print(account.get_balance())  
account.deposit(-500)  
print(account.get_balance())  