*** Settings ***
Resource    resource.robot
Library     SeleniumLibrary

*** Test Cases ***
Test Verify Page Loaded
    Open Highlight Detail Page
    Verify Highlight Detail Loaded
    Close Browser Session

Test Click Tag Link
    Open Highlight Detail Page
    Verify Highlight Detail Loaded
    Click Tag Link
    Close Browser Session

Test Gallery Image Modal
    Open Highlight Detail Page
    Verify Highlight Detail Loaded
    Click Gallery Image And Verify Modal
    Close Modal
    Close Browser Session