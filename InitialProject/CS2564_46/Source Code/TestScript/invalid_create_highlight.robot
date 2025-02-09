*** Settings ***
Documentation     This is a test suite for invalid creating a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TITLE}             Testing
${DESCRIPTION}       This is a test for creating a highlight.
${PICTURE_PATH}      ${CURDIR}\\highlight.png
${PAPER_ID}          1

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials
Create Highlight
    Go To Highlight Setting Page
    Click Highlight Create Button

Empty Title
    Fill Highlight Form With Validation    ${EMPTY}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}            
Empty Description
    Fill Highlight Form With Validation    ${TITLE}    ${EMPTY}    ${PICTURE_PATH}    ${PAPER_ID}
Empty Picture
    Go back to Create Highlight
    Fill Highlight Form With Validation Without Image    ${TITLE}    ${DESCRIPTION}    ${EMPTY}    ${PAPER_ID}        
Empty Paper
    Go back to Create Highlight
    Fill Highlight Form With Validation    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${EMPTY}        
Unchecked IsSelected
    Fill Highlight Form With Validation Without IsSelected    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID} 
  
*** Keywords ***
Click Highlight Create Button
    Click Link    xpath=//a[text()='สร้าง highlight']

*** Keywords ***
Fill Highlight Form With Validation
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    Click Element    xpath=//input[@name='isSelected']
    Click Button    xpath=//button[@type='submit']

Fill Highlight Form With Validation Without Image
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    # Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    Click Element    xpath=//input[@name='isSelected']
    Click Button    xpath=//button[@type='submit']

Fill Highlight Form With Validation Without IsSelected
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    # Click Element    xpath=//input[@name='isSelected']
    Click Button    xpath=//button[@type='submit']

Go back to Create Highlight
    Click Link    xpath=//a[text()='สร้าง highlight']