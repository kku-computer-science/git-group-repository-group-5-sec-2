*** Settings ***
Library    SeleniumLibrary
Resource          resource.robot

*** Test Cases ***
Test Clicking Highlight Paper Image
    Open Web Page
    Click Highlight Paper Image

Test Clicking Highlight Teacher Title
    Open Web Page
    Click Teacher Title

Test Carousel Navigation
    Open Web Page
    Click Next Button
    Click Prev Button
    Close Browser