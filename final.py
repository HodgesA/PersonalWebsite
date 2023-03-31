#define global constants
COUGH = 1
FEVER = 2
EXPOSURE = 3
FATIGUE = 4
Quit = 5
#main function
def main():
  patient ={}
  
  choice = 0

  while choice != 5:
    choice = getMenuChoice()
    if choice == 1:
      cough(patient)
    if choice == 2:
      fever(patient)
    if choice == 3:
      exposed(patient)
    if choice == 4:
      fatigue(patient)
      
#get menu choice
def getMenuChoice():
  print('Do You Have Covid?')
  print('-------------------')
  print('1. Experiencing Cough?')
  print('2. Dealing with Fever?')
  print('3. Were You Exposed?')
  print('4. Are You Fatigued?')
  print('5. Quit the program')
#use try/except method for choices
  try:
    enter_choice = int(input('Enter Your Choice:'))

    while enter_choice < 1 or enter_choice > 5:
      print('ERROR')
      enter_choice = int(input('Enter Your Choice:'))
    return enter_choice

  except:
    print('Invalid input, ,must use 1-5')
    getMenuChoice(patient)



#define cough
def cough(patient):
  cough = int(input('How many days have you been coughing?'))
  if cough > 7:
    print('You Have Covid')

  else:
    print('Youre probably fine!')
# define fever
def fever(patient):
  temp = int(input('How high is your fever?'))
  if temp > 104:
    print('You Have Coronavirus')
  else:
    print('Youre probably fine!')

#define exposure
def exposed(patient):
  you = input('Have you been exposed in the last two weeks?')
  if you == 'yes':
   print('You Have Covid! QUARANTINE!')
  else:
    print('Youre probably fine!')


#define fatigue
def fatigue(patient):
  tired = input('Have you experienced chills or colder body temperature?')
  if tired == 'yes':
    print('You Have Coronavirus')
  else:
    print('Youre probably fine!')
#return main function
main()