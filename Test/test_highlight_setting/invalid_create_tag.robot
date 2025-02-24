*** Settings ***
Documentation     This is a test suite for invalid creating a tag
Resource          resource_setting_highlight.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${OLD_TAG_NAME}      cp

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Go To Create Tags Page
    Go To Highlight Setting Page
    Scroll Down
    Sleep    1s 
    Click Tag Create Button
    Title Should Be    Create Tags

Tag Name Can Not Be Null
    Fill Tag Form    ${EMPTY}
    Title Should Be    Create Tags
    Sleep    1s

Tag Name Already Exist
    Fill Tag Form              ${OLD_TAG_NAME}
    Title Should Be            Create Tags
    Element Should Contain     //div[@class='invalid-feedback']    The name has already been taken.
    Sleep    1s
    [Teardown]    Close Browser

*** Keywords ***
Click Tag Create Button
    Click Link    //div[contains(@class, 'mt-4')]//a[contains(@class, 'btn btn-primary mb-3')]  # click the create tag button

Fill Tag Form
    [Arguments]    ${TAG_NAME}
    Input Text      //input[@id='name']    ${TAG_NAME}
    Click Button    //button[@type='submit']    # confirm the creation of the tag