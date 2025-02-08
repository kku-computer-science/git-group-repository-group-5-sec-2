*** Settings ***
Documentation     This is a test suite for valid creating a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          admin@gmail.com
${PASSWORD}          12345678
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
    Fill Highlight Form
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Highlight Create Button
    Click Link    xpath=//a[text()='สร้าง highlight']

Fill Highlight Form
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    Click Element    xpath=//input[@name='isSelected']
    Click Button    xpath=//button[@type='submit']