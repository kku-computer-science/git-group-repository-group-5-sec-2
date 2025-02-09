*** Settings ***
Documentation     This is a test suite for invalid editing a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TITLE}             Edited
${DESCRIPTION}       This is a test for editing a highlight.
${PICTURE_PATH}      ${CURDIR}\\highlight2.png
${PAPER_ID}          5

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Edit Highlight
    Go To Highlight Setting Page
    Click Edit Highlight Button
Empty Title
    Fill Highlight Form With Validation    ${EMPTY}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}            
Empty Description
    Fill Highlight Form With Validation    ${TITLE}    ${EMPTY}    ${PICTURE_PATH}    ${PAPER_ID}
Empty Picture
    Click Edit Highlight Button
    Fill Highlight Form With Validation Without Image    ${TITLE}    ${DESCRIPTION}    ${EMPTY}    ${PAPER_ID}        
Empty Paper
    Click Edit Highlight Button
    Fill Highlight Form With Validation    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${EMPTY}        
Unchecked IsSelected
    Fill Highlight Form With Validation Without IsSelected    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID} 
  

*** Keywords ***
Click Edit Highlight Button
    Click Link    xpath=//a[text()='Edit']

Fill Highlight Form With Validation
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    Scroll Element Into View         xpath=//button[@type='submit']
    Click Element    xpath=//input[@name='isSelected']
    Click Button    xpath=//button[@type='submit']

Fill Highlight Form With Validation Without Image
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    # Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    Scroll Element Into View         xpath=//button[@type='submit']
    Click Element    xpath=//input[@name='isSelected']
    Click Button    xpath=//button[@type='submit']

Fill Highlight Form With Validation Without IsSelected
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    Scroll Element Into View         xpath=//button[@type='submit']
    # Click Element    xpath=//input[@name='isSelected']
    Click Button    xpath=//button[@type='submit']