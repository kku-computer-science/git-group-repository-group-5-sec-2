*** Settings ***
Documentation     This is a test suite for deleting a highlight
Resource          resource_setting_highlight.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TITLE}             งานวิจัยดีเด่น

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Delete Highlight
    Go To Highlight Setting Page
    Title Should Be    Highlight
    Click Delete Highlight Button
    Handle Alert       accept
    Scroll Down
    Sleep    2s
    [Teardown]    Close Browser

*** Keywords ***
Click Delete Highlight Button
    Scroll Element Into View    //td[text()='${TITLE}']
    Click Element               //td[text()='${TITLE}']/following-sibling::td//button[@class='btn btn-danger btn-sm']  # click the edit button of the highlight we want to edit