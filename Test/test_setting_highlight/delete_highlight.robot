*** Settings ***
Documentation     This is a test suite for deleting a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${row}               4    # row number of the highlight to be deleted    

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Delete Highlight
    Go To Highlight Setting Page
    Title Should Be    Highlight Papers
    Click Delete Highlight Button
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Delete Highlight Button
    Scroll Element Into View    xpath=//tbody/tr[${row}]//button[@class='btn btn-danger btn-sm']    
    Click Button                xpath=//tbody/tr[${row}]//button[@class='btn btn-danger btn-sm']    # find the delete button of the highlight for the row we want to delete
    ${ID}=                      Get Text    xpath=//table/tbody/tr[${row}]/td[1]    # td[1] is the ID column
    Click Button                xpath=//*[@id="deleteModal-${ID}"]/div/div/div[3]/form/button    # delete highlight using the ID