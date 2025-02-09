*** Settings ***
Documentation     This is a test suite for deleting a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Delete Highlight
    Go To Highlight Setting Page
    Click Delete Highlight Button
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Delete Highlight Button
    Click Button    xpath=//button[text()='Delete']