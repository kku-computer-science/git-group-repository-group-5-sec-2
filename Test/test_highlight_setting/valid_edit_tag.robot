*** Settings ***
Documentation     This is a test suite for valid editing a tag
Resource          resource_setting_highlight.robot
Resource    valid_edit_highlight.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${OLD_TAG_NAME}      Khamron    # old tag name that will be edited
${NEW_TAG_NAME}      Phumin     # new tag name

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Edit Tag
    Go To Highlight Setting Page
    Scroll To Bottom of Page
    Sleep    1s 
    Click Tag Edit Button
    Input Text                  //input[@id='name']    ${NEW_TAG_NAME}
    Click Button                //button[@type='submit']    # confirm the creation of the tag
    Title Should Be             Highlight 
    Scroll To Bottom of Page
    Sleep    2s
    [Teardown]    Close Browser

*** Keywords ***
Click Tag Edit Button
    Click Element    //td[text()='${OLD_TAG_NAME}']/following-sibling::td//a[@class='btn btn-warning btn-sm']  # click the edit tag button of the tag we want to edit