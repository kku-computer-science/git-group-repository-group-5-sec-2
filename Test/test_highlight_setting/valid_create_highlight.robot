*** Settings ***
Documentation     This is a test suite for valid creating a highlight
Resource          resource_setting_highlight.robot

*** Variables ***
${USERNAME}            staff@gmail.com
${PASSWORD}            123456789
${TITLE}               งานวิจัยดีเด่น
${DETAIL}              วิทยาลัยการคอมพิวเตอร์ มข. ขอแสดงความยินดีกับ นายภูมินทร์ ดวนขันธ์ ในโอกาสได้รับรางวัล วิทยานิพนธ์ดีเด่น ประจำปี 2567
${COVER_IMAGE_PATH}    ${CURDIR}\\highlight.png
${IMAGE_PATH1}         ${CURDIR}\\image1.png
${IMAGE_PATH2}         ${CURDIR}\\image2.png
${TAG1}                cp
${TAG2}                Khamron

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials
Create Highlight
    Go To Highlight Setting Page
    Click Highlight Create Button
    Input Title          ${TITLE}
    Input Detail         ${DETAIL}
    Input Cover Image    ${COVER_IMAGE_PATH}
    Input Images         ${IMAGE_PATH1}    ${IMAGE_PATH2}
    Scroll To Bottom of Page
    Select Tags          ${TAG1}    ${TAG2}
    Submit Highlight Form
    Title Should Be              Highlight
    Scroll Element Into View    //td[text()='${TITLE}']
    Sleep    2s
    [Teardown]    Close Browser

*** Keywords ***
Click Highlight Create Button
    Click Link         //div[contains(@class, 'container mt-5')]//a[contains(@class, 'btn btn-primary mb-3')]  # click the create highlight button
    Title Should Be    create Highlight
    