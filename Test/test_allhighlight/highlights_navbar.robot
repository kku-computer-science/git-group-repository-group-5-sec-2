*** Settings ***
Resource    resource.robot
Library     SeleniumLibrary

*** Test Cases ***
Test Highlights Navbar
    [Documentation]    Verify that clicking the navbar "Highlights" navigates to the All Highlights page correctly
    Open Web Page
    Click Navbar Highlights
    Verify All Highlights Page
    Close Browser
