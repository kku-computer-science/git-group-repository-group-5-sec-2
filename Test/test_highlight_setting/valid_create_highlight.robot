*** Settings ***
Documentation     This is a test suite for valid creating a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TITLE}             งานวิจัยดีเด่น
${DESCRIPTION}       วิทยาลัยการคอมพิวเตอร์ มข. ขอแสดงความยินดีกับ นายภูมินทร์ ดวนขันธ์ ในโอกาสได้รับรางวัล วิทยานิพนธ์ดีเด่น ประจำปี 2567
${PICTURE_PATH}      ${CURDIR}\\highlight.png
${RESEARCHER_ID}     2
${IS_SELECTED}       1

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials
Create Highlight
    Go To Highlight Setting Page
    Click Highlight Create Button
    Title Should Be    Create Highlight Paper
    Fill Highlight Form
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Highlight Create Button
    Click Link    xpath=//a[@class='fw-bold btn btn-primary']  # click the create highlight button
    Title Should Be    Create Highlight Paper

Fill Highlight Form
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//input[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@id='researcherSelect']    ${RESEARCHER_ID}
    Select From List By Index    xpath=//select[@id='paperSelect']    1
    Select From List By Value    xpath=//select[@name='isSelected']    ${IS_SELECTED}      # click for display highlight at the home page
    Scroll Element Into View     xpath=//button[@class='btn btn-primary']
    Click Button                 xpath=//button[@class='btn btn-primary']    # click the create highlight button
    Click Button                 xpath=//button[@id='confirmCreateBtn']      # confirm the creation of the highlight
    Title Should Be    Highlight Papers