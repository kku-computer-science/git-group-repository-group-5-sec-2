*** Settings ***
Resource    resource.robot
Library     SeleniumLibrary

*** Test Cases ***
Test Click Highlight Link
    [Documentation]    Verify that clicking the valid highlight link navigates to the highlight detail page.
    Open Web Page
    Click Valid Highlight Link
    Close Browser Session

Test Next Buttons
    [Documentation]    Verify that clicking the next button changes the active slide.
    Open Web Page
    Store Initial Active Slide
    Click Valid Next Button
    Close Browser Session

Test Prev Buttons
    [Documentation]    Verify that clicking the previous button changes the active slide.
    Open Web Page
    Store Initial Active Slide
    Click Valid Prev Button
    Close Browser Session
