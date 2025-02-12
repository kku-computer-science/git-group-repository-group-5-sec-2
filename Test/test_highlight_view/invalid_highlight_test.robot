*** Settings ***
Library    SeleniumLibrary
Resource          resource.robot

*** Test Cases ***
Test Invalid Highlight Paper Image Click
    Open Web Page
    Click Invalid Highlight Paper Image
    Close Browser

Test Invalid Author Name Click
    Open Web Page
    Click Invalid Author Name
    Close Browser

Test Invalid Next Button Click
    Open Web Page
    Click Invalid Next Button
    Close Browser

Test Invalid Prev Button Click
    Open Web Page
    Click Invalid Prev Button
    Close Browser