*** Settings ***
Resource    resource.robot
Library     SeleniumLibrary

*** Test Cases ***
Test Highlight Link Does Not Exist
    [Documentation]    Verify that clicking a non-existent highlight link does not change the URL.
    Open Web Page
    Click Invalid Highlight Link
    Close Browser Session

Test Next Button Does Not Exist
    [Documentation]    Verify that clicking an invalid next button does not change the active slide.
    Open Web Page
    Click Invalid Next Button
    Close Browser Session

Test Prev Button Does Not Exist
    [Documentation]    Verify that clicking an invalid previous button does not change the active slide.
    Open Web Page
    Click Invalid Prev Button
    Close Browser Session
