*** Settings ***
Documentation     This is a test suite for valid editing a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          admin@gmail.com
${PASSWORD}          12345678
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
    Edit Highlight Form
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Edit Highlight Button
    Click Link    xpath=//a[text()='Edit']

Edit Highlight Form
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value        xpath=//select[@name='paper_id']    ${PAPER_ID}
    Scroll Element Into View         xpath=//button[@type='submit']
    Click Element    xpath=//input[@name='isSelected']
    Click Button     xpath=//button[@type='submit']