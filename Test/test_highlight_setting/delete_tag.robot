*** Settings ***
Documentation     This is a test suite for valid delete a tag
Resource          resource_setting_highlight.robot
Library    XML

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TAGET_TAG_NAME}    Phumin

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Delete Tag
    Go To Highlight Setting Page
    Scroll Element Into View      //td[text()='${TAGET_TAG_NAME}']
    Sleep    1s
    Click Element                 //td[text()='${TAGET_TAG_NAME}']/following-sibling::td//button[@class='btn btn-danger btn-sm']  # click the delete tag button of the tag we want to delete
    Sleep    1s
    Handle Alert    accept   # confirm the deletion of the tag    
    Scroll To Bottom of Page
    Sleep    1s
    [Teardown]    Close Browser