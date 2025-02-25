*** Settings ***
Documentation     This is a test suite for valid creating a tag
Resource          resource_setting_highlight.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TAG_NAME}          Khamron

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Create Tag
    Go To Highlight Setting Page
    Scroll Down
    Sleep    1s 
    Click Tag Create Button
    Title Should Be    Create Tags
    Input Text      //input[@id='name']    ${TAG_NAME}
    Click Button    //button[@type='submit']    # confirm the creation of the tag
    Title Should Be   Highlight
    Scroll To Bottom of Page
    Sleep    2s
    [Teardown]    Close Browser

*** Keywords ***
Click Tag Create Button
    Click Link    //div[contains(@class, 'mt-4')]//a[contains(@class, 'btn btn-primary mb-3')]  # click the create tag button