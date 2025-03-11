*** Settings ***
Resource    resource.robot
Library     SeleniumLibrary

*** Test Cases ***
Test Tag Filter Page
    Open Tag Page
    Verify Tag Page Loaded
    Click First Highlight
    Close Tag Page
