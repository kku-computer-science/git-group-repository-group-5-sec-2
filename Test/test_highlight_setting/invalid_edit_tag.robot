*** Settings ***
Documentation     This is a test suite for invalid editing a tag
Resource          resource_setting_highlight.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TAGET_TAG_NAME}    Phumin  # tag name that will be edited
${ALREADY_TAG_NAME}  cp 

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Go To Edit Tags Page
    Go To Highlight Setting Page
    Scroll Element Into View    //td[text()='${TAGET_TAG_NAME}']
    Click Element               //td[text()='${TAGET_TAG_NAME}']/following-sibling::td//a[@class='btn btn-warning btn-sm']  # click the edit tag button of the tag we want to edit

Tag Name Can Not Be Null
    Fill Tag Form      ${EMPTY}
    Title Should Be    Create Tags
    Sleep    1s

Tag Name Already Exist
    Fill Tag Form             ${ALREADY_TAG_NAME}
    Title Should Be           Create Tags
    Element Should Contain    xpath=//div[@class='invalid-feedback']    The name has already been taken.
    Sleep    1s
    [Teardown]    Close Browser

*** Keywords ***
Fill Tag Form
    [Arguments]    ${TAG_NAME}
    Input Text      xpath=//input[@id='name']    ${TAG_NAME}
    Click Button    xpath=//button[@type='submit']    # confirm the creation of the tag